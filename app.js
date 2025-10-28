// Main Application Logic
// Converted from SvelteKit to vanilla JavaScript for cPanel hosting

class UKDataCleanerApp {
    constructor() {
        this.fileProcessor = new FileProcessor('international');
        this.phoneValidator = new PhoneNumberValidator('international');
        this.selectedFile = null;
        this.results = null;
        this.error = null;
        this.maxFileSizeMB = this.calculateMaxFileSize();
        this.fileHeaders = [];
        this.selectedFields = [];
        this.fileData = [];
        this.activeTab = 'summary';

        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // File input and upload
        const fileInput = document.getElementById('fileInput');
        const chooseFileBtn = document.getElementById('chooseFileBtn');
        const chooseDifferentBtn = document.getElementById('chooseDifferentBtn');
        const fileDropZone = document.getElementById('fileDropZone');
        const processBtn = document.getElementById('processBtn');

        chooseFileBtn?.addEventListener('click', () => fileInput?.click());
        chooseDifferentBtn?.addEventListener('click', () => this.resetForm());
        fileInput?.addEventListener('change', (e) => this.handleFileSelect(e));
        processBtn?.addEventListener('click', () => this.processFile());

        // Drag and drop
        fileDropZone?.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileDropZone.classList.add('dragover');
        });

        fileDropZone?.addEventListener('dragleave', () => {
            fileDropZone.classList.remove('dragover');
        });

        fileDropZone?.addEventListener('drop', (e) => {
            e.preventDefault();
            fileDropZone.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                this.handleFile(files[0]);
            }
        });

        // Field selection
        const selectAllBtn = document.getElementById('selectAllBtn');
        const clearAllBtn = document.getElementById('clearAllBtn');
        const autoSelectBtn = document.getElementById('autoSelectBtn');

        selectAllBtn?.addEventListener('click', () => this.selectAllFields());
        clearAllBtn?.addEventListener('click', () => this.clearFieldSelection());
        autoSelectBtn?.addEventListener('click', () => this.autoSelectCleanableFields());

        // Phone format
        const phoneFormatRadios = document.querySelectorAll('input[name="phoneFormat"]');
        phoneFormatRadios.forEach(radio => {
            radio.addEventListener('change', () => this.updatePhoneFormat());
        });

        // Export buttons
        const exportCleanedBtn = document.getElementById('exportCleanedBtn');
        const exportReportBtn = document.getElementById('exportReportBtn');
        const exportExcelBtn = document.getElementById('exportExcelBtn');
        const exportJsonBtn = document.getElementById('exportJsonBtn');
        const processNewBtn = document.getElementById('processNewBtn');

        exportCleanedBtn?.addEventListener('click', () => this.exportResults('cleaned-csv'));
        exportReportBtn?.addEventListener('click', () => this.exportResults('csv'));
        exportExcelBtn?.addEventListener('click', () => this.exportResults('excel'));
        exportJsonBtn?.addEventListener('click', () => this.exportResults('json'));
        processNewBtn?.addEventListener('click', () => this.resetForm());

        // Tab navigation
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                // Get tab name from button itself or closest parent
                const tabName = e.target.dataset.tab || e.target.closest('.tab-btn')?.dataset.tab;
                if (tabName) {
                    this.switchTab(tabName);
                }
            });
        });

        // Test functionality
        const testInput = document.getElementById('testInput');
        const testExamples = document.querySelectorAll('.test-example');

        testInput?.addEventListener('input', (e) => this.testPhoneNumber(e.target.value));
        testExamples.forEach(btn => {
            btn.addEventListener('click', (e) => {
                const example = e.target.dataset.example;
                testInput.value = example;
                this.testPhoneNumber(example);
            });
        });

        // Back to top buttons
        const backToTopBtns = document.querySelectorAll('#backToTopBtn, #backToTopBtn2');
        backToTopBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    async handleFileSelect(event) {
        console.log('handleFileSelect called');
        const target = event.target;
        if (target.files && target.files.length > 0) {
            console.log('File selected:', target.files[0].name);
            await this.handleFile(target.files[0]);
        }
    }

    calculateMaxFileSize() {
        // Detect available memory and calculate safe file size limit
        const deviceMemory = navigator.deviceMemory || 2; // Default to 2GB if not available
        const chromeMemory = navigator.hardwareConcurrency || 4; // CPU cores

        // Conservative calculation: use 10% of device memory for file processing
        // Assume 1 byte of raw data expands to ~3 bytes when parsed into objects/arrays
        let estimatedMaxMB = (deviceMemory * 1024 * 0.1) / 3;

        // Apply floor and ceiling based on device capabilities
        if (deviceMemory <= 2) {
            estimatedMaxMB = Math.min(estimatedMaxMB, 50); // 50MB for low-end devices
        } else if (deviceMemory <= 4) {
            estimatedMaxMB = Math.min(estimatedMaxMB, 100); // 100MB for mid-range
        } else {
            estimatedMaxMB = Math.min(estimatedMaxMB, 500); // 500MB for high-end
        }

        // Never go below 10MB - even old devices can handle that
        return Math.max(estimatedMaxMB, 10);
    }

    checkFileSize(file) {
        const fileSizeMB = file.size / (1024 * 1024);
        const maxMB = this.maxFileSizeMB;

        if (fileSizeMB > maxMB) {
            return {
                safe: false,
                message: `⚠️ Warning: This file (${fileSizeMB.toFixed(1)} MB) exceeds the recommended limit of ${maxMB.toFixed(0)} MB for your device. Processing may be slow or cause your browser to become unresponsive.`,
                canStillProcess: fileSizeMB < maxMB * 2 // Allow up to 2x with warning
            };
        } else if (fileSizeMB > maxMB * 0.8) {
            return {
                safe: true,
                warning: true,
                message: `ℹ️ This file (${fileSizeMB.toFixed(1)} MB) is close to the recommended limit. Processing may take a moment.`
            };
        }

        return {
            safe: true,
            warning: false,
            message: null
        };
    }

    async handleFile(file) {
        console.log('handleFile called with:', file.name);

        // Check file size
        const sizeCheck = this.checkFileSize(file);
        if (!sizeCheck.safe && !sizeCheck.canStillProcess) {
            this.showError(sizeCheck.message);
            return;
        }

        this.selectedFile = file;
        this.error = null;
        this.results = null;
        this.hideFieldSelection();
        this.selectedFields = [];

        // Update UI
        this.showFileSelected(file.name, file.size);

        // Show file size info
        if (sizeCheck.warning || !sizeCheck.safe) {
            this.showError(sizeCheck.message);
        }

        // Parse file headers to show field selection
        try {
            console.log('Reading file...');
            const text = await this.readFileAsText(file);
            console.log('File read, parsing...');
            const lines = text.split('\n').filter(line => line.trim());
            console.log('Found', lines.length, 'lines');
            if (lines.length > 0) {
                // Use proper CSV parsing for headers
                this.fileHeaders = this.parseCSVLine(lines[0]);
                console.log('Headers:', this.fileHeaders);
                // Parse all data rows properly
                this.fileData = lines.map(line => this.parseCSVLine(line));
                console.log('Showing field selection...');
                this.showFieldSelection();
            }
        } catch (err) {
            console.error('Error reading file:', err);
            this.showError('Could not read file headers');
        }
    }

    readFileAsText(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.onerror = () => reject(new Error('Failed to read file'));
            reader.readAsText(file);
        });
    }

    parseCSVLine(line) {
        const result = [];
        let current = '';
        let inQuotes = false;

        for (let i = 0; i < line.length; i++) {
            const char = line[i];

            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === ',' && !inQuotes) {
                result.push(current.trim());
                current = '';
            } else {
                current += char;
            }
        }

        result.push(current.trim());
        return result;
    }

    showFileSelected(fileName, fileSize = null) {
        const uploadPrompt = document.getElementById('uploadPrompt');
        const fileSelected = document.getElementById('fileSelected');
        const fileNameElement = document.getElementById('fileName');
        const fileSizeElement = document.getElementById('fileSize');

        if (uploadPrompt) uploadPrompt.style.display = 'none';
        if (fileSelected) fileSelected.classList.remove('hidden');
        if (fileNameElement) fileNameElement.textContent = fileName;

        if (fileSizeElement && fileSize) {
            const sizeMB = (fileSize / (1024 * 1024)).toFixed(1);
            fileSizeElement.textContent = `(${sizeMB} MB)`;
        }
    }

    showFieldSelection() {
        const fieldSelection = document.getElementById('fieldSelection');
        const fieldCheckboxes = document.getElementById('fieldCheckboxes');

        if (fieldSelection) fieldSelection.classList.remove('hidden');
        if (fieldCheckboxes) {
            this.renderFieldCheckboxes();
        }

        // Auto-scroll to field selection section after a short delay
        setTimeout(() => {
            fieldSelection?.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }, 300);
    }

    hideFieldSelection() {
        const fieldSelection = document.getElementById('fieldSelection');
        if (fieldSelection) fieldSelection.classList.add('hidden');
    }

    renderFieldCheckboxes() {
        const fieldCheckboxes = document.getElementById('fieldCheckboxes');
        if (!fieldCheckboxes) return;

        // Filter fields that we can actually clean
        const cleanableFields = this.fileHeaders.filter(field =>
            /phone|mobile|tel|number|ni|insurance|postcode|sort|code|bank/i.test(field)
        );

        if (cleanableFields.length === 0) {
            fieldCheckboxes.innerHTML = `
                <div class="text-center p-6 bg-yellow-50 rounded-lg border border-yellow-200">
                    <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <h4 class="text-lg font-semibold text-yellow-800 mb-2">No Cleanable Fields Found</h4>
                    <p class="text-yellow-700">
                        This file doesn't contain columns we can clean (phone numbers, NI numbers, postcodes, or sort codes).
                    </p>
                </div>
            `;
            return;
        }

        // Get field type and icon for each field
        const getFieldInfo = (fieldName) => {
            const field = fieldName.toLowerCase();
            if (field.includes('phone') || field.includes('mobile') || field.includes('tel')) {
                return {
                    type: 'Phone Number',
                    icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>`,
                    bgColor: 'bg-blue-100',
                    textColor: 'text-blue-600',
                    borderColor: 'border-blue-200'
                };
            } else if (field.includes('ni') || field.includes('insurance')) {
                return {
                    type: 'NI Number',
                    icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 12a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M15 11h3m-3 4h2"></path></svg>`,
                    bgColor: 'bg-purple-100',
                    textColor: 'text-purple-600',
                    borderColor: 'border-purple-200'
                };
            } else if (field.includes('postcode') || field.includes('post_code') || field.includes('zip')) {
                return {
                    type: 'Postcode',
                    icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>`,
                    bgColor: 'bg-green-100',
                    textColor: 'text-green-600',
                    borderColor: 'border-green-200'
                };
            } else if (field.includes('sort') || field.includes('bank') || field.includes('account')) {
                return {
                    type: 'Sort Code',
                    icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>`,
                    bgColor: 'bg-yellow-100',
                    textColor: 'text-yellow-600',
                    borderColor: 'border-yellow-200'
                };
            }
            return {
                type: 'Other',
                icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>`,
                bgColor: 'bg-gray-100',
                textColor: 'text-gray-600',
                borderColor: 'border-gray-200'
            };
        };

        fieldCheckboxes.innerHTML = cleanableFields.map(field => {
            const fieldInfo = getFieldInfo(field);
            return `
                <label class="field-card block cursor-pointer group">
                    <div class="bg-white rounded-lg p-4 border-2 border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all duration-200 group-hover:bg-indigo-50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 ${fieldInfo.bgColor} rounded-full flex items-center justify-center ${fieldInfo.textColor}">
                                    ${fieldInfo.icon}
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 group-hover:text-indigo-800">${field}</h4>
                                    <p class="text-sm text-gray-600 group-hover:text-indigo-600">${fieldInfo.type}</p>
                                </div>
                            </div>
                            <input
                                type="checkbox"
                                value="${field}"
                                class="field-checkbox w-5 h-5 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2"
                            />
                        </div>
                    </div>
                </label>
            `;
        }).join('');

        // Add event listeners to checkboxes
        const checkboxes = fieldCheckboxes.querySelectorAll('.field-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', () => this.updateFieldSelection());
        });

        this.updateFieldSelection();
    }

    updateFieldSelection() {
        const checkboxes = document.querySelectorAll('.field-checkbox');
        this.selectedFields = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        this.updateFieldSelectionStatus();
        this.updateProcessButton();
    }

    updateFieldSelectionStatus() {
        const status = document.getElementById('fieldSelectionStatus');
        if (!status) return;

        if (this.selectedFields.length === 0) {
            status.textContent = '⚠️ Please select at least one field to clean';
            status.className = 'text-sm text-orange-600 mt-3 text-center';
        } else {
            status.textContent = `✅ ${this.selectedFields.length} field(s) selected for cleaning`;
            status.className = 'text-sm text-green-600 mt-3 text-center';
        }
    }

    updateProcessButton() {
        const processBtn = document.getElementById('processBtn');
        if (!processBtn) return;

        if (this.selectedFields.length > 0) {
            processBtn.classList.remove('hidden');
        } else {
            processBtn.classList.add('hidden');
        }
    }

    selectAllFields() {
        const checkboxes = document.querySelectorAll('.field-checkbox');
        checkboxes.forEach(cb => cb.checked = true);
        this.updateFieldSelection();
    }

    clearFieldSelection() {
        const checkboxes = document.querySelectorAll('.field-checkbox');
        checkboxes.forEach(cb => cb.checked = false);
        this.updateFieldSelection();
    }

    autoSelectCleanableFields() {
        this.selectedFields = this.fileHeaders.filter(field =>
            /phone|mobile|tel|number|ni|insurance|postcode|sort|code|bank/i.test(field)
        );

        const checkboxes = document.querySelectorAll('.field-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = this.selectedFields.includes(cb.value);
        });

        this.updateFieldSelection();
    }

    updatePhoneFormat() {
        const selectedFormat = document.querySelector('input[name="phoneFormat"]:checked')?.value || 'international';
        this.fileProcessor.updatePhoneFormat(selectedFormat);
        this.phoneValidator.setOutputFormat(selectedFormat);
    }

    async processFile() {
        if (!this.selectedFile || this.selectedFields.length === 0) return;

        const processBtn = document.getElementById('processBtn');
        if (processBtn) {
            processBtn.disabled = true;
            processBtn.textContent = 'Processing...';
        }

        this.hideError();

        try {
            // Ensure phone format is synchronized before processing
            this.updatePhoneFormat();
            // Process the file with selected columns
            this.results = await this.fileProcessor.processFile(this.selectedFile, this.selectedFields);
            this.showResults();
        } catch (err) {
            this.showError(err instanceof Error ? err.message : 'An error occurred while processing the file');
        } finally {
            if (processBtn) {
                processBtn.disabled = false;
                processBtn.textContent = 'Clean My Data';
            }
        }
    }

    showResults() {
        const resultsSection = document.getElementById('resultsSection');
        if (!resultsSection || !this.results) return;

        resultsSection.classList.remove('hidden');

        // Update summary cards
        this.updateSummaryCards();

        // Update tab counts
        this.updateTabCounts();

        // Render tables
        this.renderSummaryTable();
        this.renderCleanedTable();
        this.renderIssuesTable();

        // Set initial tab visibility
        document.getElementById('summaryTab')?.classList.remove('hidden');
        document.getElementById('summaryTab')?.classList.add('active');
        document.getElementById('cleanedTab')?.classList.add('hidden');
        document.getElementById('issuesTab')?.classList.add('hidden');

        // Scroll to results
        resultsSection.scrollIntoView({ behavior: 'smooth' });
    }

    updateSummaryCards() {
        const totalRows = document.getElementById('totalRows');
        const totalValid = document.getElementById('totalValid');
        const totalFixed = document.getElementById('totalFixed');
        const totalInvalid = document.getElementById('totalInvalid');

        if (totalRows) totalRows.textContent = this.results.totalRows;
        if (totalValid) totalValid.textContent = this.results.summary.totalValid;
        if (totalFixed) totalFixed.textContent = this.results.summary.totalFixed;
        if (totalInvalid) totalInvalid.textContent = this.results.summary.totalInvalid;
    }

    updateTabCounts() {
        const cleanedCount = document.getElementById('cleanedCount');
        const issuesCount = document.getElementById('issuesCount');

        if (cleanedCount) cleanedCount.textContent = this.results.summary.totalFixed;
        if (issuesCount) issuesCount.textContent = this.results.summary.totalInvalid;
    }

    renderSummaryTable() {
        const tbody = document.getElementById('summaryTableBody');
        if (!tbody) return;

        const summaryData = this.results.processedRows
            .slice(0, 5)
            .flatMap(row =>
                row.validationResults
                    .slice(0, 2)
                    .filter(result => result.fixed && result.fixed !== result.value)
                    .map(result => ({ row, result }))
            );

        tbody.innerHTML = summaryData.map(({ row, result }) => `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-sm text-gray-500">${row.rowNumber}</td>
                <td class="px-4 py-2 text-sm font-medium">${result.column}</td>
                <td class="px-4 py-2 text-sm"><code class="bg-gray-100 px-2 py-1 rounded">${result.value}</code></td>
                <td class="px-4 py-2 text-sm"><code class="bg-green-100 px-2 py-1 rounded text-green-800">${result.fixed}</code></td>
            </tr>
        `).join('');
    }

    renderCleanedTable() {
        const tbody = document.getElementById('cleanedTableBody');
        if (!tbody) return;

        const cleanedData = this.results.processedRows
            .flatMap(row =>
                row.validationResults
                    .filter(result => result.fixed && result.isValid)
                    .map(result => ({ row, result }))
            );

        tbody.innerHTML = cleanedData.map(({ row, result }) => `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-sm text-gray-500">${row.rowNumber}</td>
                <td class="px-4 py-2 text-sm font-medium">${result.column}</td>
                <td class="px-4 py-2 text-sm"><code class="bg-gray-100 px-2 py-1 rounded">${result.value}</code></td>
                <td class="px-4 py-2 text-sm"><code class="bg-green-100 px-2 py-1 rounded text-green-800">${result.fixed}</code></td>
                <td class="px-4 py-2 text-sm text-blue-600">${result.detectedType}</td>
            </tr>
        `).join('');
    }

    renderIssuesTable() {
        const tbody = document.getElementById('issuesTableBody');
        if (!tbody) return;

        const issuesData = this.results.processedRows
            .flatMap(row =>
                row.validationResults
                    .filter(result => !result.isValid)
                    .map(result => ({ row, result }))
            );

        tbody.innerHTML = issuesData.map(({ row, result }) => `
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-sm text-gray-500">${row.rowNumber}</td>
                <td class="px-4 py-2 text-sm font-medium">${result.column}</td>
                <td class="px-4 py-2 text-sm"><code class="bg-red-100 px-2 py-1 rounded text-red-800">${result.value}</code></td>
                <td class="px-4 py-2 text-sm text-red-600">${result.error}</td>
                <td class="px-4 py-2 text-sm">
                    ${this.getComplianceStandard(result.column, result.detectedType)}
                </td>
            </tr>
        `).join('');
    }

    getComplianceStandard(columnName, detectedType) {
        const column = columnName.toLowerCase();

        if (column.includes('ni') || column.includes('insurance')) {
            return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">HMRC Compliant</span>';
        } else if (column.includes('phone') || column.includes('mobile')) {
            return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">UK Standard</span>';
        } else {
            return '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Industry Standard</span>';
        }
    }

    switchTab(tabName) {
        // Update active tab button
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            if (btn.dataset.tab === tabName) {
                btn.classList.add('border-blue-500', 'text-blue-600');
                btn.classList.remove('border-transparent', 'text-gray-500');
            } else {
                btn.classList.remove('border-blue-500', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-500');
            }
        });

        // Update active tab content
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => {
            if (content.id === `${tabName}Tab`) {
                content.classList.remove('hidden');
                content.classList.add('active');
            } else {
                content.classList.add('hidden');
                content.classList.remove('active');
            }
        });

        this.activeTab = tabName;
    }

    async exportResults(format) {
        if (!this.results) return;

        try {
            // Check if user wants to include "Cleaned" columns
            const includeCleanedColumn = document.getElementById('includeCleanedColumn')?.checked || false;

            const blob = await this.fileProcessor.exportResults(this.results, format, includeCleanedColumn);
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;

            const fileExtension = format === 'cleaned-csv' ? 'csv' : format === 'excel' ? 'csv' : format;
            const originalName = this.selectedFile?.name.replace(/\.[^/.]+$/, '') || 'validation_results';
            const suffix = format === 'cleaned-csv' ? '_cleaned' :
                format === 'csv' ? '_validation_report' :
                    format === 'excel' ? '_excel_friendly' : '';

            a.download = `${originalName}${suffix}.${fileExtension}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (err) {
            this.showError('Failed to export results');
        }
    }

    testPhoneNumber(input) {
        const testResult = document.getElementById('testResult');
        const testStatus = document.getElementById('testStatus');
        const testInputValue = document.getElementById('testInputValue');
        const testOutput = document.getElementById('testOutput');
        const testOutputValue = document.getElementById('testOutputValue');

        if (!input.trim()) {
            if (testResult) testResult.classList.add('hidden');
            return;
        }

        const result = this.phoneValidator.validate(input);

        if (testResult) testResult.classList.remove('hidden');
        if (testInputValue) testInputValue.textContent = result.value;

        if (result.isValid) {
            if (testStatus) {
                testStatus.innerHTML = `
                    <span class="text-green-600 font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Valid & Cleaned
                    </span>
                `;
            }
            if (testOutput) testOutput.classList.remove('hidden');
            if (testOutputValue) testOutputValue.textContent = result.fixed;
        } else {
            if (testStatus) {
                testStatus.innerHTML = `
                    <span class="text-red-600 font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Cannot Process
                    </span>
                `;
            }
            if (testOutput) testOutput.classList.add('hidden');
        }
    }

    showError(message) {
        const errorDisplay = document.getElementById('errorDisplay');
        const errorMessage = document.getElementById('errorMessage');

        if (errorDisplay) errorDisplay.classList.remove('hidden');
        if (errorMessage) errorMessage.textContent = message;

        this.error = message;
    }

    hideError() {
        const errorDisplay = document.getElementById('errorDisplay');
        if (errorDisplay) errorDisplay.classList.add('hidden');
        this.error = null;
    }

    resetForm() {
        this.selectedFile = null;
        this.results = null;
        this.error = null;
        this.fileHeaders = [];
        this.selectedFields = [];
        this.fileData = [];

        // Reset UI
        const fileInput = document.getElementById('fileInput');
        const uploadPrompt = document.getElementById('uploadPrompt');
        const fileSelected = document.getElementById('fileSelected');
        const resultsSection = document.getElementById('resultsSection');
        const processBtn = document.getElementById('processBtn');

        if (fileInput) fileInput.value = '';
        if (uploadPrompt) uploadPrompt.style.display = 'block';
        if (fileSelected) fileSelected.classList.add('hidden');
        if (resultsSection) resultsSection.classList.add('hidden');
        if (processBtn) processBtn.classList.add('hidden');

        // Reset tabs to default state
        document.getElementById('summaryTab')?.classList.remove('hidden');
        document.getElementById('summaryTab')?.classList.add('active');
        document.getElementById('cleanedTab')?.classList.add('hidden');
        document.getElementById('issuesTab')?.classList.add('hidden');

        this.hideFieldSelection();
        this.hideError();
    }
}

// Initialize the app when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const app = new UKDataCleanerApp();

    // Display file size limit info
    const fileSizeLimit = document.getElementById('fileSizeLimit');
    if (fileSizeLimit) {
        fileSizeLimit.textContent = `Recommended limit: ${app.maxFileSizeMB.toFixed(0)} MB (calculated for your device)`;
    }
});
