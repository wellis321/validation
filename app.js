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

        // Issues report button
        const issuesReportBtn = document.getElementById('issuesReportBtn');
        if (issuesReportBtn) {
            // Remove any existing listeners first to prevent duplicates
            const newBtn = issuesReportBtn.cloneNode(true);
            issuesReportBtn.parentNode?.replaceChild(newBtn, issuesReportBtn);
            newBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.viewIssuesReport();
            });
        }

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

        // Export button
        const exportBtn = document.getElementById('exportBtn');
        const processNewBtn = document.getElementById('processNewBtn');

        exportBtn?.addEventListener('click', () => {
            const format = document.getElementById('downloadFormat')?.value || 'csv';
            this.exportResults(format);
        });
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
        // Detect available memory and browser capabilities
        const deviceMemory = navigator.deviceMemory || null;
        const hardwareConcurrency = navigator.hardwareConcurrency || 4;
        const userAgent = navigator.userAgent.toLowerCase();

        // Detect browser
        let browser = 'unknown';
        if (userAgent.includes('chrome') && !userAgent.includes('edg')) {
            browser = 'Chrome';
        } else if (userAgent.includes('firefox')) {
            browser = 'Firefox';
        } else if (userAgent.includes('safari') && !userAgent.includes('chrome')) {
            browser = 'Safari';
        } else if (userAgent.includes('edg')) {
            browser = 'Edge';
        }

        // Calculate based on browser and device capabilities
        let estimatedMaxMB;
        let recommendation = '';

        if (deviceMemory !== null) {
            // Chrome/Edge: deviceMemory API is available (accurate)
            estimatedMaxMB = Math.min(deviceMemory * 30, 500);
            recommendation = `${browser} detected with ${deviceMemory}GB RAM`;
        } else {
            // Firefox/Safari: deviceMemory API not available, use conservative estimate
            estimatedMaxMB = 50;
            recommendation = `${browser} detected (conservative limit)`;

            // Try to be slightly more generous for higher core counts
            if (hardwareConcurrency >= 8) {
                estimatedMaxMB = 75;
            }
        }

        // Store browser info for display
        this.browserInfo = {
            name: browser,
            hasDeviceMemory: deviceMemory !== null,
            cores: hardwareConcurrency,
            memoryGB: deviceMemory || 'unknown',
            recommendation: recommendation
        };

        return Math.max(estimatedMaxMB, 10); // Minimum 10MB
    }

    checkFileSize(file) {
        const fileSizeMB = file.size / (1024 * 1024);
        const maxMB = this.maxFileSizeMB;

        if (fileSizeMB > maxMB) {
            return {
                safe: false,
                message: `<svg class="inline w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg> Warning: This file (${fileSizeMB.toFixed(1)} MB) exceeds the recommended limit of ${maxMB.toFixed(0)} MB for your device. Processing may be slow or cause your browser to become unresponsive.`,
                canStillProcess: fileSizeMB < maxMB * 2 // Allow up to 2x with warning
            };
        } else if (fileSizeMB > maxMB * 0.8) {
            return {
                safe: true,
                warning: true,
                message: `<svg class="inline w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> This file (${fileSizeMB.toFixed(1)} MB) is close to the recommended limit. Processing may take a moment.`
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
            
            // Check if it's an Excel file - use FileProcessor's readFileContent for proper handling
            const isExcel = file.type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                file.type === 'application/vnd.ms-excel' ||
                file.name.endsWith('.xlsx') ||
                file.name.endsWith('.xls');
            const isJson = file.type === 'application/json' || file.name.endsWith('.json');
            
            if (isExcel || isJson) {
                // Use FileProcessor to properly read Excel/JSON files
                const content = await this.fileProcessor.readFileContent(file);
                
                let rows;
                if (content.type === 'excel') {
                    rows = content.data;
                } else if (content.type === 'json') {
                    rows = this.fileProcessor.parseJSON(content.data);
                } else {
                    throw new Error('Unexpected content type from FileProcessor');
                }
                
                if (rows.length > 0) {
                    this.fileHeaders = rows[0];
                    this.fileData = rows;
                    console.log('Headers:', this.fileHeaders);
                    console.log('Showing field selection...');
                    this.showFieldSelection();
                }
            } else {
                // Handle CSV/text files with existing method
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
            }
        } catch (err) {
            console.error('Error reading file:', err);
            this.showError('Could not read file headers: ' + err.message);
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

        // Detect protected columns early
        const protectedColumns = this.detectProtectedColumns(this.fileHeaders);

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

        // Show protected columns info if any exist
        let protectedInfo = '';
        if (protectedColumns.length > 0) {
            protectedInfo = `
                <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-400 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800 mb-1">Protected Columns Detected</p>
                            <p class="text-xs text-blue-700">
                                The following columns appear to be identifiers and will never be modified:
                                <strong>${protectedColumns.join(', ')}</strong>
                            </p>
                        </div>
                    </div>
                </div>
            `;
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

        fieldCheckboxes.innerHTML = protectedInfo + cleanableFields.map(field => {
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
            status.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Please select at least one field to clean</span>
                </div>
            `;
            status.className = 'text-sm text-orange-600 mt-3 text-center';
        } else {
            status.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>${this.selectedFields.length} field(s) selected for cleaning</span>
                </div>
            `;
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

    showLoadingState(message = 'Please wait while we validate your data...', progress = 0) {
        const overlay = document.getElementById('loadingOverlay');
        const messageEl = document.getElementById('loadingMessage');
        const progressBar = document.getElementById('loadingProgressBar');
        const progressText = document.getElementById('loadingProgress');

        if (overlay) {
            overlay.classList.remove('hidden');
        }
        if (messageEl) {
            messageEl.textContent = message;
        }
        if (progressBar) {
            progressBar.style.width = `${progress}%`;
        }
        if (progressText) {
            if (progress > 0) {
                progressText.textContent = `${Math.round(progress)}% complete`;
            } else {
                progressText.textContent = 'Preparing...';
            }
        }
    }

    hideLoadingState() {
        const overlay = document.getElementById('loadingOverlay');
        if (overlay) {
            overlay.classList.add('hidden');
        }
    }

    updateLoadingProgress(current, total) {
        const progress = (current / total) * 100;
        const progressBar = document.getElementById('loadingProgressBar');
        const progressText = document.getElementById('loadingProgress');

        if (progressBar) {
            progressBar.style.width = `${progress}%`;
        }
        if (progressText) {
            progressText.textContent = `Processing row ${current.toLocaleString()} of ${total.toLocaleString()}`;
        }
    }

    async processFile() {
        if (!this.selectedFile || this.selectedFields.length === 0) return;

        const processBtn = document.getElementById('processBtn');
        if (processBtn) {
            processBtn.disabled = true;
            processBtn.textContent = 'Processing...';
        }

        this.hideError();
        this.showLoadingState();

        try {
            // Ensure phone format is synchronized before processing
            this.updatePhoneFormat();

            // Process the file with selected columns and progress callback
            this.results = await this.fileProcessor.processFile(
                this.selectedFile,
                this.selectedFields,
                (current, total) => this.updateLoadingProgress(current, total)
            );

            this.hideLoadingState();
            this.showResults();
        } catch (err) {
            this.hideLoadingState();
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

        // Detect protected columns
        this.protectedColumns = this.detectProtectedColumns(this.fileHeaders);

        // Identify duplicate rows
        this.duplicateRowIndices = this.identifyDuplicateRows();

        // Update data profiling section
        this.updateDataProfiling();

        // Update summary cards
        this.updateSummaryCards();

        // Update tab counts
        this.updateTabCounts();

        // Render tables
        this.renderSummaryTable();
        this.renderCleanedTable();
        this.renderIssuesTable();
        this.renderPreviewTable();

        // Update download summary
        this.updateDownloadSummary();

        // Update duplicate count message
        this.updateDuplicateCountMessage();

        // Set initial tab visibility
        document.getElementById('summaryTab')?.classList.remove('hidden');
        document.getElementById('summaryTab')?.classList.add('active');
        document.getElementById('cleanedTab')?.classList.add('hidden');
        document.getElementById('issuesTab')?.classList.add('hidden');
        document.getElementById('previewTab')?.classList.add('hidden');

        // Scroll to results
        resultsSection.scrollIntoView({ behavior: 'smooth' });
    }

    updateDataProfiling() {
        const profilingSection = document.getElementById('dataProfilingSection');
        if (!profilingSection) return;

        // Check if profiling data exists
        if (!this.results || !this.results.profiling) {
            profilingSection.classList.add('hidden');
            return;
        }

        const profiling = this.results.profiling;

        // Show the profiling section
        profilingSection.classList.remove('hidden');

        // Update summary stats
        const totalMissingEl = document.getElementById('totalMissing');
        const totalDuplicatesEl = document.getElementById('totalDuplicates');
        const uniqueRowsEl = document.getElementById('uniqueRows');

        if (totalMissingEl) totalMissingEl.textContent = profiling.totalMissing || 0;
        if (totalDuplicatesEl) totalDuplicatesEl.textContent = profiling.duplicateRows || 0;

        const uniqueRows = Math.max(0, this.results.totalRows - 1 - (profiling.duplicateRows || 0)); // -1 for header
        if (uniqueRowsEl) uniqueRowsEl.textContent = uniqueRows;

        // Update missing values table
        this.renderMissingValuesTable(profiling.missingByColumn);
    }

    renderMissingValuesTable(missingByColumn) {
        const tableContainer = document.getElementById('missingValuesTable');
        const tbody = document.getElementById('missingValuesTableBody');

        if (!tableContainer || !tbody) return;

        const entries = Object.entries(missingByColumn || {});

        if (entries.length === 0) {
            tableContainer.classList.add('hidden');
            return;
        }

        tableContainer.classList.remove('hidden');

        const totalRows = this.results.totalRows - 1; // Exclude header

        tbody.innerHTML = entries.map(([column, count]) => {
            const percentage = totalRows > 0 ? ((count / totalRows) * 100).toFixed(1) : 0;
            return `
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm font-medium text-gray-900">${this.escapeHtml(column)}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">${count}</td>
                    <td class="px-4 py-2 text-sm text-gray-700">${percentage}%</td>
                </tr>
            `;
        }).join('');
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
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

        // Show/hide detailed issues report button
        const issuesReportBtn = document.getElementById('issuesReportBtn');
        if (issuesReportBtn) {
            if (issuesData.length > 0) {
                issuesReportBtn.classList.remove('hidden');
            } else {
                issuesReportBtn.classList.add('hidden');
            }
        }
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

    generateDetailedIssuesReport() {
        const issuesData = this.results.processedRows
            .flatMap(row =>
                row.validationResults
                    .filter(result => !result.isValid)
                    .map(result => ({ row, result }))
            );

        if (issuesData.length === 0) {
            return null;
        }

        // Group issues by type for better organization
        const issuesByType = {};
        issuesData.forEach(({ row, result }) => {
            const type = result.detectedType || 'unknown';
            if (!issuesByType[type]) {
                issuesByType[type] = [];
            }
            issuesByType[type].push({ row, result });
        });

        // Generate detailed explanations for each issue
        const generateIssueExplanation = (result) => {
            const column = result.column.toLowerCase();
            const error = result.error || '';
            const value = result.value;

            // Extract prefix from NI numbers
            const extractNIPrefix = (val) => {
                const cleaned = val.replace(/[^A-Z]/gi, '').toUpperCase();
                return cleaned.substring(0, 2);
            };

            // NI Number explanations - check error message FIRST (most reliable)
            // This catches cases where detectedType is 'unknown' but error message has details
            if (error.includes('Invalid first letter') || error.includes('Invalid second letter') || 
                error.includes('banned by HMRC') || error.includes('administrative prefix') ||
                error.includes('NI number') || error.includes('not used in NI number prefixes') ||
                column.includes('ni') || column.includes('insurance') || 
                result.detectedType === 'ni_number') {
                
                const prefix = extractNIPrefix(value);
                
                // Parse specific error messages
                if (error.includes('Invalid first letter')) {
                    // Extract the letter from error message: "Invalid first letter 'X'"
                    const letterMatch = error.match(/first letter '([A-Z])'/);
                    const letter = letterMatch ? letterMatch[1] : prefix[0];
                    
                    return `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">NI Number:</td>
                            <td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Prefix:</td>
                            <td style="padding: 8px;"><strong>${prefix}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td>
                            <td style="padding: 8px; color: #dc2626;"><strong>First letter "${letter}" is not allowed</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td>
                            <td style="padding: 8px;">The first letter "${letter}" is not used in NI number prefixes according to UK HMRC standards.<br><br>
                            <strong>Invalid first letters:</strong> D, F, I, Q, U, V</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td>
                            <td style="padding: 8px;">Verify this NI number with the individual. If it's correct, it may need to be reported to HMRC.</td>
                        </tr>
                    </table>`;
                } else if (error.includes('Invalid second letter')) {
                    // Extract the letter from error message: "Invalid second letter 'X'"
                    const letterMatch = error.match(/second letter '([A-Z])'/);
                    const letter = letterMatch ? letterMatch[1] : prefix[1];
                    
                    return `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">NI Number:</td>
                            <td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Prefix:</td>
                            <td style="padding: 8px;"><strong>${prefix}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td>
                            <td style="padding: 8px; color: #dc2626;"><strong>Second letter "${letter}" is not allowed</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td>
                            <td style="padding: 8px;">The second letter "${letter}" is not used in NI number prefixes according to UK HMRC standards.<br><br>
                            <strong>Invalid second letters:</strong> D, F, I, O, Q, U, V</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td>
                            <td style="padding: 8px;">Verify this NI number with the individual. If it's correct, it may need to be reported to HMRC.</td>
                        </tr>
                    </table>`;
                } else if (error.includes('banned by HMRC')) {
                    const prefixMatch = error.match(/prefix '([A-Z]{2})'/);
                    const bannedPrefix = prefixMatch ? prefixMatch[1] : prefix;
                    
                    return `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">NI Number:</td>
                            <td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Prefix:</td>
                            <td style="padding: 8px;"><strong>${bannedPrefix}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td>
                            <td style="padding: 8px; color: #dc2626;"><strong>Prefix "${bannedPrefix}" is banned by HMRC</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td>
                            <td style="padding: 8px;">The prefix "${bannedPrefix}" is banned by HMRC standards and cannot be used in valid NI numbers.<br><br>
                            <strong>Banned prefixes:</strong> BG, GB, KN, NK, NT, TN, ZZ</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td>
                            <td style="padding: 8px;">Verify this NI number with the individual.</td>
                        </tr>
                    </table>`;
                } else if (error.includes('administrative prefix')) {
                    const prefixMatch = error.match(/'([A-Z]{2})'/);
                    const adminPrefix = prefixMatch ? prefixMatch[1] : prefix;
                    
                    return `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">NI Number:</td>
                            <td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Prefix:</td>
                            <td style="padding: 8px;"><strong>${adminPrefix}</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td>
                            <td style="padding: 8px; color: #dc2626;"><strong>"${adminPrefix}" is an administrative prefix</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td>
                            <td style="padding: 8px;">This prefix is reserved for administrative use, not valid NI numbers.<br><br>
                            <strong>Administrative prefixes:</strong> OO, FY, NC, PZ</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td>
                            <td style="padding: 8px;">Verify this NI number with the individual.</td>
                        </tr>
                    </table>`;
                } else if (error.includes('Invalid NI number format')) {
                    return `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Value:</td>
                            <td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td>
                            <td style="padding: 8px; color: #dc2626;"><strong>Invalid format</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td>
                            <td style="padding: 8px;">NI numbers must be in the format: 2 letters + 6 digits + 1 letter (e.g., AB123456C)</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td>
                            <td style="padding: 8px;">Verify the format and check for typos or missing characters.</td>
                        </tr>
                    </table>`;
                }
            }

            // Phone number explanations
            if (column.includes('phone') || column.includes('mobile') || column.includes('tel') || result.detectedType === 'phone_number') {
                let explanation = `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Phone Number:</td><td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td></tr>`;
                
                if (error.includes('multiple plus signs')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Multiple plus signs found</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">Phone numbers should only have one plus sign at the start (for international format). Multiple plus signs indicate a formatting error.</td></tr>`;
                } else if (error.includes('look-alike characters')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Contains look-alike characters</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The value contains characters that look like numbers but aren't (O, I, l). These need to be manually corrected.</td></tr>`;
                } else if (error.includes('unusual digit groupings')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Unusual digit groupings</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The phone number has too many digit groups or the total length doesn't match UK phone number standards (10-11 digits).</td></tr>`;
                } else if (error.includes('Invalid UK phone number format')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Invalid format</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The phone number doesn't match UK phone number patterns. UK numbers should be:<br>• Mobile: 7xxxxxxxxx (10 digits starting with 7)<br>• Landline: 0xxxxxxxxx (11 digits starting with 0)<br>• International: +44xxxxxxxxx (12 digits starting with +44)</td></tr>`;
                } else {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>${this.escapeHtml(error)}</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The phone number format is invalid or cannot be recognized.</td></tr>`;
                }
                
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td><td style="padding: 8px;">Verify the phone number format. UK phone numbers should be in formats like:<br>• <strong>International:</strong> +44 7700 900123<br>• <strong>UK Mobile:</strong> 07700 900123<br>• <strong>UK Landline:</strong> 020 7946 0958</td></tr>`;
                explanation += `</table>`;
                return explanation;
            }

            // Postcode explanations
            if (column.includes('postcode') || column.includes('post code') || result.detectedType === 'postcode') {
                let explanation = `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Postcode:</td><td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td></tr>`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Invalid UK postcode format</strong></td></tr>`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">UK postcodes must follow specific patterns:<br>• <strong>Format:</strong> [1-2 letters][1-2 digits][0-1 letter] [1 digit][2 letters]<br>• <strong>Examples:</strong> SW1A 1AA, M1 1AA, CR2 6XH, EC1A 1BB<br>• The postcode must have a space before the last 3 characters</td></tr>`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td><td style="padding: 8px;">Verify the postcode format. Check for:<br>• Missing or incorrect spacing<br>• Wrong number of letters or digits<br>• Invalid character combinations<br>• Typos in the postcode</td></tr>`;
                explanation += `</table>`;
                return explanation;
            }

            // Sort code explanations
            if ((column.includes('sort') && column.includes('code')) || result.detectedType === 'sort_code') {
                let explanation = `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Sort Code:</td><td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td></tr>`;
                
                // Extract digits to show what was found
                const digits = value.replace(/\D/g, '');
                
                if (error.includes('cannot contain letters')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Contains letters</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">Sort codes are purely numeric and cannot contain any letters. The value "${this.escapeHtml(value)}" contains letters, which makes it invalid.</td></tr>`;
                } else if (error.includes('must be exactly 6 digits')) {
                    const digitCount = digits.length;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Wrong number of digits (found ${digitCount}, need 6)</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">UK sort codes must be exactly 6 digits. The value "${this.escapeHtml(value)}" contains ${digitCount} digit${digitCount !== 1 ? 's' : ''}.</td></tr>`;
                    if (digitCount < 6) {
                        explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Possible issue:</td><td style="padding: 8px;">The sort code may be missing digits or may have been truncated.</td></tr>`;
                    } else if (digitCount > 6) {
                        explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Possible issue:</td><td style="padding: 8px;">The sort code may have extra digits or may be combined with an account number.</td></tr>`;
                    }
                } else {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>${this.escapeHtml(error)}</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The sort code format is invalid.</td></tr>`;
                }
                
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td><td style="padding: 8px;">Verify the sort code. UK sort codes must be:<br>• <strong>Exactly 6 digits</strong> (no letters)<br>• <strong>Format:</strong> XX-XX-XX (e.g., 12-34-56)<br>• <strong>Examples:</strong> 12-34-56, 23-45-67, 40-02-34</td></tr>`;
                explanation += `</table>`;
                return explanation;
            }

            // Bank account explanations
            if ((column.includes('account') && (column.includes('bank') || column.includes('number'))) || result.detectedType === 'bank_account') {
                let explanation = `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">`;
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Account Number:</td><td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td></tr>`;
                
                // Extract digits to show what was found
                const digits = value.replace(/\D/g, '');
                
                if (error.includes('cannot contain letters')) {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Contains letters</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">Bank account numbers are purely numeric and cannot contain any letters. The value "${this.escapeHtml(value)}" contains letters, which makes it invalid.</td></tr>`;
                } else if (error.includes('must be 7-12 digits')) {
                    const digitCount = digits.length;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>Wrong number of digits (found ${digitCount}, need 7-12)</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">UK bank account numbers must be between 7 and 12 digits. The value "${this.escapeHtml(value)}" contains ${digitCount} digit${digitCount !== 1 ? 's' : ''}.</td></tr>`;
                    if (digitCount < 7) {
                        explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Possible issue:</td><td style="padding: 8px;">The account number may be missing digits or may have been truncated.</td></tr>`;
                    } else if (digitCount > 12) {
                        explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Possible issue:</td><td style="padding: 8px;">The account number may have extra digits or may be combined with other information.</td></tr>`;
                    }
                } else {
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Problem:</td><td style="padding: 8px; color: #dc2626;"><strong>${this.escapeHtml(error)}</strong></td></tr>`;
                    explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Explanation:</td><td style="padding: 8px;">The account number format is invalid.</td></tr>`;
                }
                
                explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td><td style="padding: 8px;">Verify the account number. UK bank account numbers must be:<br>• <strong>7-12 digits</strong> (most common is 8 digits)<br>• <strong>Purely numeric</strong> (no letters or special characters)<br>• <strong>Examples:</strong> 12345678, 1234567890</td></tr>`;
                explanation += `</table>`;
                return explanation;
            }

            // Generic explanation - try to parse error message for more details
            let explanation = `<table style="width: 100%; border-collapse: collapse; margin: 10px 0;">`;
            explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600; width: 150px;">Value:</td><td style="padding: 8px;"><code style="background: #fee2e2; padding: 4px 8px; border-radius: 4px;">${this.escapeHtml(value)}</code></td></tr>`;
            explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">Error:</td><td style="padding: 8px; color: #dc2626;">${this.escapeHtml(error)}</td></tr>`;
            explanation += `<tr><td style="padding: 8px; background: #f9fafb; font-weight: 600;">What to do:</td><td style="padding: 8px;">Review the value and verify it matches the expected format for this field.</td></tr>`;
            explanation += `</table>`;
            return explanation;
        };

        // Generate sidebar navigation before building HTML
        const sidebarNav = Object.entries(issuesByType).map(([type, issues]) => {
            const typeId = 'issue-type-' + type.replace(/[^a-z0-9]/gi, '-').toLowerCase();
            const displayName = this.getTypeDisplayName(type);
            return `<a href="#${typeId}" onclick="event.preventDefault(); document.getElementById('${typeId}').scrollIntoView({behavior: 'smooth', block: 'start'}); return false;">${displayName} (${issues.length})</a>`;
        }).join('');

        // Generate unique report ID for refresh detection
        const reportId = Date.now().toString();

        // Build HTML report
        const html = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detailed Validation Issues Report</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }
        .sidebar {
            position: sticky;
            top: 20px;
            height: fit-content;
            width: 220px;
            flex-shrink: 0;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            max-height: calc(100vh - 40px);
            overflow-y: auto;
        }
        .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e5e7eb;
        }
        .sidebar-header a {
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: opacity 0.2s;
        }
        .sidebar-header a:hover {
            opacity: 0.8;
        }
        .sidebar-logo {
            width: 60px;
            height: auto;
            margin: 0 auto 8px;
            display: block;
        }
        .sidebar-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
                padding: 10px;
            }
            .sidebar {
                position: relative;
                top: 0;
                width: 100%;
                margin-bottom: 20px;
                max-height: none;
            }
            .container {
                padding: 15px;
            }
            h1 {
                font-size: 1.5rem;
            }
            table {
                font-size: 0.875rem;
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            th, td {
                padding: 8px;
                white-space: nowrap;
            }
            .action-buttons {
                flex-direction: column;
            }
            .action-btn {
                width: 100%;
                justify-content: center;
            }
            .warning-banner {
                padding: 15px;
            }
            .explanation {
                font-size: 0.875rem;
                padding: 12px;
            }
        }
        @media (max-width: 480px) {
            body {
                padding: 5px;
            }
            .container {
                padding: 10px;
            }
            h1 {
                font-size: 1.25rem;
            }
            .subtitle {
                font-size: 0.875rem;
            }
            th, td {
                padding: 6px;
                font-size: 0.75rem;
            }
            .value {
                font-size: 0.75rem;
                padding: 2px 6px;
            }
        }
        .sidebar h3 {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e5e7eb;
            text-align: center;
        }
        .sidebar nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .sidebar a {
            display: block;
            padding: 8px 12px;
            color: #4b5563;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .sidebar a:hover {
            background: #f3f4f6;
            color: #1f2937;
        }
        .sidebar a.active {
            background: #eff6ff;
            color: #2563eb;
            font-weight: 600;
        }
        .container {
            flex: 1;
            max-width: 1000px;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #1f2937;
            margin-bottom: 10px;
            font-size: 2rem;
        }
        .subtitle {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 1rem;
        }
        .summary {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        .summary h2 {
            color: #92400e;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }
        .issue-type {
            margin-bottom: 40px;
            scroll-margin-top: 20px;
        }
        .issue-type h3 {
            color: #1f2937;
            background: #e5e7eb;
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }
        th {
            background: #f9fafb;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        tr:hover {
            background: #f9fafb;
        }
        .row-number {
            color: #6b7280;
            font-weight: 500;
        }
        .column-name {
            font-weight: 600;
            color: #1f2937;
        }
        .value {
            font-family: 'Courier New', monospace;
            background: #fee2e2;
            color: #991b1b;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9rem;
        }
        .error {
            color: #dc2626;
            font-weight: 500;
        }
        .explanation {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            line-height: 1.7;
        }
        .explanation strong {
            color: #1e40af;
        }
        .warning-banner {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 8px;
        }
        .warning-content {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #92400e;
            margin-bottom: 15px;
        }
        .warning-icon {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
            margin-top: 2px;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .print-btn {
            background: #ffffff;
            color: #92400e;
            border: 2px solid #f59e0b;
        }
        .print-btn:hover {
            background: #fef3c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }
        .download-btn {
            background: #f59e0b;
            color: #ffffff;
        }
        .download-btn:hover {
            background: #d97706;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.9rem;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 8px;
        }
        .badge-hmrc {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-uk {
            background: #d1fae5;
            color: #065f46;
        }
    </style>
</head>
<body data-report-id="${reportId}">
        ${sidebarNav ? `
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="/">
                    <img src="/assets/images/Data Cleaning Icon 300.png" alt="Simple Data Cleaner" class="sidebar-logo">
                    <h2 class="sidebar-title">Simple Data Cleaner</h2>
                </a>
            </div>
            <h3>Navigation</h3>
            <nav>
                ${sidebarNav}
            </nav>
        </div>
        ` : ''}
        <div class="container">
        <div class="warning-banner">
            <div class="warning-content">
                <svg class="warning-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div style="flex: 1;">
                    <strong>Save this report:</strong> This report will persist when you refresh the page, but for permanent storage, please download or print it:
                </div>
            </div>
            <div class="action-buttons">
                <button onclick="window.print(); return false;" class="action-btn print-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Print Report
                </button>
                <button onclick="downloadReport(); return false;" class="action-btn download-btn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Report
                </button>
            </div>
        </div>
        <h1>Detailed Validation Issues Report</h1>
        <p class="subtitle">Generated on ${new Date().toLocaleString()}</p>

        <div class="summary">
            <h2>Summary</h2>
            <p><strong>Total Issues Found:</strong> ${issuesData.length}</p>
            <p><strong>File:</strong> ${this.results.fileName || 'Unknown'}</p>
            <p><strong>Total Rows Processed:</strong> ${this.results.totalRows}</p>
        </div>

        ${Object.entries(issuesByType).map(([type, issues]) => {
            const typeId = 'issue-type-' + type.replace(/[^a-z0-9]/gi, '-').toLowerCase();
            const displayName = this.getTypeDisplayName(type);
            const issueCount = issues.length;
            const issueText = issueCount === 1 ? 'issue' : 'issues';
            
            const issuesHtml = issues.map(({ row, result }) => {
                return '<tr>' +
                    '<td class="row-number">' + row.rowNumber + '</td>' +
                    '<td class="column-name">' + result.column + '</td>' +
                    '<td><code class="value">' + this.escapeHtml(result.value) + '</code></td>' +
                    '<td class="error">' + this.escapeHtml(result.error) + '</td>' +
                    '</tr>' +
                    '<tr>' +
                    '<td colspan="4">' +
                    '<div class="explanation">' +
                    generateIssueExplanation(result) +
                    '</div>' +
                    '</td>' +
                    '</tr>';
            }).join('');
            
            return '<div class="issue-type" id="' + typeId + '">' +
                '<h3>' + displayName + ' (' + issueCount + ' ' + issueText + ')</h3>' +
                '<table>' +
                '<thead>' +
                '<tr><th>Row</th><th>Column</th><th>Invalid Value</th><th>Error Message</th></tr>' +
                '</thead>' +
                '<tbody>' + issuesHtml + '</tbody>' +
                '</table>' +
                '</div>';
        }).join('')}

        <div class="footer">
            <p>This report was generated by Simple Data Cleaner</p>
            <p>For more information, visit <a href="https://simple-data-cleaner.com">simple-data-cleaner.com</a></p>
        </div>
    </div>
    <script>
        // Highlight active section in sidebar on scroll
        (function() {
            const sections = document.querySelectorAll('.issue-type');
            const navLinks = document.querySelectorAll('.sidebar nav a');
            
            function updateActiveLink() {
                let current = '';
                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.clientHeight;
                    if (window.pageYOffset >= (sectionTop - 100)) {
                        current = section.getAttribute('id');
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', updateActiveLink);
            updateActiveLink(); // Initial call
        })();
        
        // Download report function
        function downloadReport() {
            const html = document.documentElement.outerHTML;
            const blob = new Blob([html], { type: 'text/html' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'detailed_issues_report_' + new Date().toISOString().split('T')[0] + '.html';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
    <script>
        // Simple restoration - only on refresh when page is blank
        (function() {
            // #region agent log
            fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:restore-script',message:'Restoration script loaded',data:{readyState:document.readyState,bodyExists:!!document.body,bodyChildren:document.body?document.body.children.length:0,url:window.location.href},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'A'})}).catch(()=>{});
            // #endregion
            
            function attemptRestore() {
                // #region agent log
                fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'attemptRestore called',data:{readyState:document.readyState,bodyExists:!!document.body,bodyChildren:document.body?document.body.children.length:0,url:window.location.href,isAboutBlank:window.location.href==='about:blank'},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'C'})}).catch(()=>{});
                // #endregion
                
                const stored = localStorage.getItem('detailedIssuesReport');
                const storedId = localStorage.getItem('detailedIssuesReportId');

                // #region agent log
                fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Checked localStorage',data:{hasStored:!!stored,hasStoredId:!!storedId,storedLength:stored?stored.length:0},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'B'})}).catch(()=>{});
                // #endregion
                
                if (!stored || !storedId) {
                    // #region agent log
                    fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'No stored report found, aborting',data:{},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'B'})}).catch(()=>{});
                    // #endregion
                    return;
                }
                
                const body = document.body;
                const url = window.location.href;
                const isAboutBlank = url === 'about:blank' || url === 'about:srcdoc';
                const bodyEmpty = body && body.children.length === 0;
                // Check if body contains report content (has data-report-id attribute on body or any element)
                const hasReportContent = body && (body.hasAttribute('data-report-id') || body.querySelector('[data-report-id]'));
                
                // #region agent log
                fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Checking body state',data:{bodyExists:!!body,bodyChildren:body?body.children.length:0,bodyEmpty:bodyEmpty,url:url,isAboutBlank:isAboutBlank,hasReportContent:!!hasReportContent},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'C'})}).catch(()=>{});
                // #endregion
                
                // Always restore if body is empty OR we don't have report content
                // This handles: empty body (refresh clears content), about:blank, or browser navigation
                if (bodyEmpty || !hasReportContent) {
                    // #region agent log
                    fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Conditions met, attempting restore',data:{bodyEmpty:bodyEmpty,isAboutBlank:isAboutBlank,hasReportContent:!!hasReportContent,url:url},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'E'})}).catch(()=>{});
                    // #endregion
                    try {
                        document.open('text/html', 'replace');
                        document.write(stored);
                        document.close();
                        // #region agent log
                        fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Restore completed',data:{bodyChildren:document.body?document.body.children.length:0,url:window.location.href},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'E'})}).catch(()=>{});
                        // #endregion
                    } catch (e) {
                        // #region agent log
                        fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Restore failed',data:{error:e.message},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'E'})}).catch(()=>{});
                        // #endregion
                    }
                } else {
                    // #region agent log
                    fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:attemptRestore',message:'Conditions not met, skipping restore',data:{bodyEmpty:bodyEmpty,isAboutBlank:isAboutBlank,hasReportContent:!!hasReportContent,url:url},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'C'})}).catch(()=>{});
                    // #endregion
                }
            }
            
            // Run immediately - don't wait
            attemptRestore();
            
            // Also try on DOMContentLoaded as backup
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', attemptRestore);
            }
            
            // Also listen for pageshow (refresh/back button)
            window.addEventListener('pageshow', function(e) {
                // #region agent log
                fetch('http://127.0.0.1:7244/ingest/f4b795a6-59bf-4d16-914e-33211b89c823',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({location:'app.js:restore-script',message:'pageshow event fired',data:{persisted:e.persisted,bodyChildren:document.body?document.body.children.length:0,url:window.location.href},timestamp:Date.now(),sessionId:'debug-session',runId:'refresh-debug',hypothesisId:'D'})}).catch(()=>{});
                // #endregion
                setTimeout(attemptRestore, 10);
            });
        })();
    </script>
</body>
</html>`;

        return { html, reportId };
    }

    getTypeDisplayName(type) {
        const names = {
            'ni_number': 'National Insurance Numbers',
            'phone_number': 'Phone Numbers',
            'postcode': 'Postcodes',
            'sort_code': 'Sort Codes',
            'bank_account': 'Bank Account Numbers',
            'unknown': 'Other Issues'
        };
        return names[type] || type.charAt(0).toUpperCase() + type.slice(1).replace(/_/g, ' ');
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    downloadIssuesReport() {
        const result = this.generateDetailedIssuesReport();
        if (!result || !result.html) {
            this.showError('No issues found to generate report');
            return;
        }
        const { html } = result;

        const blob = new Blob([html], { type: 'text/html' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        const originalName = this.selectedFile?.name.replace(/\.[^/.]+$/, '') || 'validation_results';
        a.download = `${originalName}_detailed_issues_report.html`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }

    viewIssuesReport() {
        // Prevent multiple simultaneous calls
        if (this._isOpeningReport) {
            return;
        }
        
        this._isOpeningReport = true;
        
        const result = this.generateDetailedIssuesReport();
        if (!result || !result.html) {
            this._isOpeningReport = false;
            this.showError('No issues found to generate report');
            return;
        }

        const { html, reportId } = result;

        // Store in localStorage for restoration on refresh
        try {
            localStorage.setItem('detailedIssuesReport', html);
            localStorage.setItem('detailedIssuesReportId', reportId);
        } catch (e) {
            console.warn('Could not store report in localStorage:', e);
        }

        // Open the dedicated report viewer page
        // This page will load the report from localStorage and can be refreshed
        window.open('/issues-report.php', '_blank');
        
        // Reset flag after a delay
        setTimeout(() => {
            this._isOpeningReport = false;
        }, 1000);
    }

    detectProtectedColumns(headers) {
        const protectedPatterns = [
            /^id$/i, /^.*_id$/i, /^pk$/i, /^key$/i,
            /^.*key$/i, /^order.*number$/i, /^customer.*id$/i,
            /^reference$/i, /^ref$/i, /^.*ref$/i,
            /^account.*id$/i, /^user.*id$/i, /^transaction.*id$/i,
            /^invoice.*number$/i, /^purchase.*order$/i
        ];

        return headers.filter(header =>
            protectedPatterns.some(pattern => pattern.test(header))
        );
    }

    renderPreviewTable() {
        const headerRow = document.getElementById('previewTableHeader');
        const tbody = document.getElementById('previewTableBody');
        const rowCount = document.getElementById('previewRowCount');
        const colCount = document.getElementById('previewColCount');

        if (!headerRow || !tbody || !this.results) return;

        const headers = this.fileHeaders;
        const datasetResult = this.buildFullCleanedDataset();
        const cleanedData = datasetResult.cleanedData;

        // Build header row
        headerRow.innerHTML = `
            <th class="px-4 py-2 text-left border-b-2 border-gray-300 bg-gray-100 sticky top-0 text-xs font-semibold text-gray-700">#</th>
            ${headers.map(header => {
                const isProtected = this.protectedColumns && this.protectedColumns.includes(header);
                return `<th class="px-4 py-2 text-left border-b-2 border-gray-300 bg-gray-100 sticky top-0 text-xs font-semibold text-gray-700">
                    ${isProtected ? '<svg class="inline w-4 h-4 text-gray-600 align-middle mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg> ' : ''}${this.escapeHtml(header)}
                </th>`;
            }).join('')}
        `;

        // Build table rows
        tbody.innerHTML = cleanedData.map((row, index) => {
            const isDuplicate = this.isDuplicateRow(index);
            const isOriginal = this.isOriginalOfDuplicate(index);

            // Determine row styling
            let rowBgClass, hoverClass, badge = '';

            if (isDuplicate) {
                // Duplicate row - yellow/amber
                rowBgClass = 'bg-amber-50 border-l-4 border-amber-400';
                hoverClass = 'hover:bg-amber-100';
                badge = '<span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-amber-200 text-amber-800">DUPLICATE</span>';
            } else if (isOriginal) {
                // Original row (has duplicates) - blue
                rowBgClass = 'bg-blue-50 border-l-4 border-blue-400';
                hoverClass = 'hover:bg-blue-100';
                badge = '<span class="ml-1 inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-200 text-blue-800">HAS DUPLICATES</span>';
            } else {
                // Normal row - alternating white/gray
                rowBgClass = index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                hoverClass = 'hover:bg-gray-50';
            }

            return `
                <tr class="${hoverClass} ${rowBgClass}">
                    <td class="px-4 py-2 border-b border-gray-200 text-xs text-gray-500 font-mono">
                        ${index + 1}
                        ${badge}
                    </td>
                    ${row.map((cell, colIndex) => {
                        const wasModified = this.wasCellModified(index, headers[colIndex]);
                        // Cell background: duplicates get amber, originals get blue, modified get green
                        let bgClass = '';
                        if (isDuplicate) {
                            bgClass = 'bg-amber-50';
                        } else if (isOriginal) {
                            bgClass = 'bg-blue-50';
                        } else if (wasModified) {
                            bgClass = 'bg-green-50';
                        }
                        return `<td class="px-4 py-2 border-b border-gray-200 text-xs ${bgClass}">${this.escapeHtml(cell || '')}</td>`;
                    }).join('')}
                </tr>
            `;
        }).join('');

        // Update counts
        if (rowCount) rowCount.textContent = cleanedData.length;
        if (colCount) colCount.textContent = headers.length;
    }

    buildFullCleanedDataset() {
        if (!this.results || !this.fileData) return { cleanedData: [], issuesByRow: [] };

        const cleanedData = [];
        const issuesByRow = [];
        const headers = this.fileHeaders;

        // For each original row (skip header row which is index 0)
        for (let i = 1; i < this.fileData.length; i++) {
            const originalRow = this.fileData[i];
            const cleanedRow = [...originalRow]; // Start with original
            const issuesList = [];

            // Find validation results for this row (row numbers are 1-indexed, starting from 2 for data)
            const rowResults = this.results.processedRows.find(r => r.rowNumber === i + 1);

            if (rowResults) {
                // Apply cleaned values to selected columns only and collect issues
                rowResults.validationResults.forEach(result => {
                    const colIndex = headers.indexOf(result.column);
                    if (colIndex !== -1 && result.isValid && result.fixed) {
                        cleanedRow[colIndex] = result.fixed;
                    } else if (colIndex !== -1 && !result.isValid) {
                        // Track invalid values for Issues column
                        issuesList.push(result.column);
                    }
                });
            }

            cleanedData.push(cleanedRow);
            issuesByRow.push(issuesList);
        }

        return { cleanedData, issuesByRow };
    }

    wasCellModified(rowIndex, columnName) {
        if (!this.results) return false;

        // Row numbers in results are 1-indexed starting from 2 (header is row 1)
        const rowNumber = rowIndex + 2;
        const rowResults = this.results.processedRows.find(r => r.rowNumber === rowNumber);

        if (!rowResults) return false;

        const result = rowResults.validationResults.find(r => r.column === columnName);
        return result && result.isValid && result.fixed && result.fixed !== result.value;
    }

    updateDownloadSummary() {
        const summarySection = document.getElementById('downloadSummary');
        if (!summarySection || !this.results) return;

        summarySection.classList.remove('hidden');

        // Calculate statistics
        const totalRows = this.results.totalRows - 1; // Exclude header
        const cleanedFields = this.results.summary.totalFixed;
        const issueRows = this.countRowsWithIssues();

        // Update summary numbers
        document.getElementById('summaryTotalRows').textContent = totalRows;
        document.getElementById('summaryCleanedFields').textContent = cleanedFields;
        document.getElementById('summaryIssueRows').textContent = issueRows;
        document.getElementById('summaryTotalCols').textContent = this.fileHeaders.length;

        // Update protected columns info
        const protectedColsEl = document.getElementById('summaryProtectedCols');
        if (protectedColsEl) {
            if (this.protectedColumns && this.protectedColumns.length > 0) {
                protectedColsEl.textContent = this.protectedColumns.join(', ');
            } else {
                protectedColsEl.textContent = 'None detected';
            }
        }

        // Update duplicate rows info
        const duplicatesEl = document.getElementById('summaryDuplicates');
        if (duplicatesEl) {
            const duplicateCount = this.duplicateRowIndices && this.duplicateRowIndices.duplicates ?
                                   this.duplicateRowIndices.duplicates.size : 0;
            if (duplicateCount === 0) {
                duplicatesEl.textContent = 'None found';
                duplicatesEl.classList.add('text-green-700');
                duplicatesEl.classList.remove('text-amber-700');
            } else {
                duplicatesEl.textContent = `${duplicateCount} duplicate${duplicateCount > 1 ? 's' : ''} found (removable via checkbox)`;
                duplicatesEl.classList.add('text-amber-700');
                duplicatesEl.classList.remove('text-green-700');
            }
        }
    }

    countRowsWithIssues() {
        if (!this.results) return 0;

        const rowsWithIssues = new Set();
        this.results.processedRows.forEach(row => {
            const hasIssue = row.validationResults.some(result => !result.isValid);
            if (hasIssue) {
                rowsWithIssues.add(row.rowNumber);
            }
        });

        return rowsWithIssues.size;
    }

    identifyDuplicateRows() {
        if (!this.fileData || this.fileData.length <= 1) return { duplicates: new Set(), originals: new Set() };

        const seen = new Map();
        const duplicates = new Set();
        const originals = new Set();

        // Skip header row (index 0), check data rows starting from index 1
        for (let i = 1; i < this.fileData.length; i++) {
            const row = this.fileData[i];
            const key = JSON.stringify(row);

            if (seen.has(key)) {
                // This is a duplicate - mark this index as a duplicate
                duplicates.add(i - 1); // Convert to 0-based index for data rows
                // Also mark the original if not already marked
                const originalIndex = seen.get(key) - 1; // Convert to 0-based
                originals.add(originalIndex);
            } else {
                seen.set(key, i);
            }
        }

        return { duplicates, originals };
    }

    isDuplicateRow(rowIndex) {
        return this.duplicateRowIndices && this.duplicateRowIndices.duplicates &&
               this.duplicateRowIndices.duplicates.has(rowIndex);
    }

    isOriginalOfDuplicate(rowIndex) {
        return this.duplicateRowIndices && this.duplicateRowIndices.originals &&
               this.duplicateRowIndices.originals.has(rowIndex);
    }

    removeDuplicates(dataset) {
        const seen = new Set();
        return dataset.filter(row => {
            const key = JSON.stringify(row);
            if (seen.has(key)) {
                return false; // Duplicate, remove it
            }
            seen.add(key);
            return true; // Keep it
        });
    }

    updateDuplicateCountMessage() {
        const messageEl = document.getElementById('duplicateCountMessage');
        if (!messageEl) return;

        const duplicateCount = this.duplicateRowIndices && this.duplicateRowIndices.duplicates ?
                               this.duplicateRowIndices.duplicates.size : 0;

        if (duplicateCount === 0) {
            messageEl.textContent = '✓ No duplicate rows found in your data.';
            messageEl.classList.add('text-green-700');
            messageEl.classList.remove('text-gray-600');
        } else {
            const totalAffected = duplicateCount + (this.duplicateRowIndices.originals ? this.duplicateRowIndices.originals.size : 0);
            messageEl.textContent = `Found ${duplicateCount} duplicate row${duplicateCount > 1 ? 's' : ''} (${totalAffected} rows affected total).`;
            messageEl.classList.add('text-amber-700');
            messageEl.classList.remove('text-gray-600');
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

    showDuplicateConfirmation(duplicateCount) {
        return new Promise((resolve) => {
            const dialog = document.getElementById('duplicateConfirmDialog');
            const countEl = document.getElementById('duplicateRemovalCount');
            const confirmBtn = document.getElementById('confirmDuplicateRemoval');
            const cancelBtn = document.getElementById('cancelDuplicateRemoval');

            if (!dialog || !countEl || !confirmBtn || !cancelBtn) {
                resolve(false);
                return;
            }

            // Update the count
            countEl.textContent = duplicateCount;

            // Show the dialog
            dialog.classList.remove('hidden');

            // Handle confirm
            const handleConfirm = () => {
                dialog.classList.add('hidden');
                confirmBtn.removeEventListener('click', handleConfirm);
                cancelBtn.removeEventListener('click', handleCancel);
                resolve(true);
            };

            // Handle cancel
            const handleCancel = () => {
                dialog.classList.add('hidden');
                confirmBtn.removeEventListener('click', handleConfirm);
                cancelBtn.removeEventListener('click', handleCancel);
                resolve(false);
            };

            confirmBtn.addEventListener('click', handleConfirm);
            cancelBtn.addEventListener('click', handleCancel);
        });
    }

    async exportResults(format) {
        if (!this.results) return;

        try {
            // Check export options
            const includeIssuesColumn = document.getElementById('includeIssuesColumn')?.checked || false;
            const onlyRowsWithIssues = document.getElementById('onlyRowsWithIssues')?.checked || false;
            const removeDuplicates = document.getElementById('removeDuplicates')?.checked || false;
            const trimWhitespace = document.getElementById('trimWhitespace')?.checked || false;

            // Build cleaned dataset
            const datasetResult = this.buildFullCleanedDataset();
            let cleanedData = datasetResult.cleanedData;
            const issuesByRow = datasetResult.issuesByRow;

            // Apply duplicate removal if requested
            // IMPORTANT: Duplicates must be identified based on ORIGINAL data, not cleaned data
            // because cleaned data may have different values (formatted phone numbers, etc.)
            if (removeDuplicates && cleanedData.length > 0) {
                const originalCount = cleanedData.length;
                let duplicateCount = 0;

                // Calculate how many duplicates will be removed
                if (this.duplicateRowIndices && this.duplicateRowIndices.duplicates) {
                    duplicateCount = this.duplicateRowIndices.duplicates.size;
                }

                // Show confirmation dialog if there are duplicates to remove
                if (duplicateCount > 0) {
                    const confirmed = await this.showDuplicateConfirmation(duplicateCount);
                    if (!confirmed) {
                        // User cancelled, uncheck the checkbox and return
                        const checkbox = document.getElementById('removeDuplicates');
                        if (checkbox) checkbox.checked = false;
                        return;
                    }
                }

                // Proceed with removal
                // Use duplicate indices identified from original data (before cleaning)
                // cleanedData indices match fileData indices (both skip header row)
                if (this.duplicateRowIndices && this.duplicateRowIndices.duplicates) {
                    // Filter out rows that are marked as duplicates in the original data
                    // cleanedData[0] corresponds to fileData[1] (first data row)
                    cleanedData = cleanedData.filter((row, index) => {
                        // index in cleanedData corresponds to (index + 1) in fileData (since fileData[0] is header)
                        // But duplicateRowIndices uses 0-based index for data rows (fileData[1] = index 0)
                        return !this.duplicateRowIndices.duplicates.has(index);
                    });
                } else {
                    // Fallback: use removeDuplicates method (compares cleaned rows)
                    cleanedData = this.removeDuplicates(cleanedData);
                }
                const removedCount = originalCount - cleanedData.length;
                console.log(`Removed ${removedCount} duplicate rows`);
            }

            // Apply whitespace trimming if requested
            if (trimWhitespace) {
                cleanedData = cleanedData.map(row =>
                    row.map(cell => {
                        if (typeof cell === 'string') {
                            return cell.trim().replace(/\s+/g, ' ');
                        }
                        return cell;
                    })
                );
            }

            // Create a modified results object with the cleaned data and issues
            const modifiedResults = {
                ...this.results,
                cleanedData: cleanedData,
                headers: this.fileHeaders,
                issuesByRow: issuesByRow // Include issues information for export
            };

            const blob = await this.fileProcessor.exportResults(modifiedResults, format, includeIssuesColumn, onlyRowsWithIssues);
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;

            // Determine file extension and suffix
            let fileExtension = format;
            let suffix = '_cleaned';

            if (format === 'csv') {
                fileExtension = 'csv';
                suffix = '_cleaned';
            } else if (format === 'excel') {
                fileExtension = 'xlsx';
                suffix = '_cleaned';
            } else if (format === 'json') {
                fileExtension = 'json';
                suffix = '_cleaned';
            }

            const originalName = this.selectedFile?.name.replace(/\.[^/.]+$/, '') || 'validation_results';
            a.download = `${originalName}${suffix}.${fileExtension}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (err) {
            this.showError('Failed to export results: ' + err.message);
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

    getErrorSuggestion(errorMessage) {
        const msg = errorMessage.toLowerCase();

        // File reading errors
        if (msg.includes('failed to read file') || msg.includes('could not read')) {
            return 'Try saving your file in a different format (CSV or XLSX) or check if the file is corrupted. Make sure the file isn\'t open in another program.';
        }

        // File type errors
        if (msg.includes('unsupported file type')) {
            return 'Please upload a CSV, Excel (.xlsx or .xls), or JSON file. If you have a different format, try converting it to CSV first.';
        }

        // File size errors
        if (msg.includes('exceeds') && msg.includes('limit')) {
            return 'Try splitting your file into smaller chunks, or remove unnecessary columns before uploading. Large files may cause browser performance issues.';
        }

        // Empty file errors
        if (msg.includes('empty') || msg.includes('no data')) {
            return 'Make sure your file contains data rows with headers in the first row. Check that the file isn\'t blank or formatted incorrectly.';
        }

        // Processing errors
        if (msg.includes('processing') || msg.includes('validation')) {
            return 'Try refreshing the page and uploading your file again. If the problem persists, check that your data is properly formatted.';
        }

        // Export errors
        if (msg.includes('export') || msg.includes('download')) {
            return 'Check that your browser allows downloads from this site. Try a different export format or disable browser extensions that might block downloads.';
        }

        // localStorage errors
        if (msg.includes('storage') || msg.includes('quota')) {
            return 'Your browser storage is full. Try clearing your browser cache or use Private/Incognito mode. You can also try a different browser.';
        }

        // Default suggestion
        return 'Try refreshing the page and attempting the action again. If the problem continues, try using a different browser or clearing your browser cache.';
    }

    showError(message) {
        const errorDisplay = document.getElementById('errorDisplay');
        const errorMessage = document.getElementById('errorMessage');
        const errorTitle = document.getElementById('errorTitle');
        const errorSuggestion = document.getElementById('errorSuggestion');
        const errorSuggestionText = document.getElementById('errorSuggestionText');

        if (errorDisplay) errorDisplay.classList.remove('hidden');
        if (errorMessage) errorMessage.innerHTML = message;

        // Determine error title based on message content
        if (errorTitle) {
            const msg = message.toLowerCase();
            if (msg.includes('warning') || msg.includes('close to')) {
                errorTitle.textContent = 'Warning';
            } else if (msg.includes('cannot') || msg.includes('failed')) {
                errorTitle.textContent = 'Error';
            } else {
                errorTitle.textContent = 'Notice';
            }
        }

        // Get and show recovery suggestion
        const suggestion = this.getErrorSuggestion(message);
        if (errorSuggestion && errorSuggestionText) {
            errorSuggestionText.textContent = suggestion;
            errorSuggestion.classList.remove('hidden');
        }

        this.error = message;

        // Scroll error into view
        if (errorDisplay) {
            errorDisplay.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    hideError() {
        const errorDisplay = document.getElementById('errorDisplay');
        const errorSuggestion = document.getElementById('errorSuggestion');

        if (errorDisplay) errorDisplay.classList.add('hidden');
        if (errorSuggestion) errorSuggestion.classList.add('hidden');

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
        document.getElementById('previewTab')?.classList.add('hidden');

        // Hide download summary
        document.getElementById('downloadSummary')?.classList.add('hidden');

        this.hideFieldSelection();
        this.hideError();
    }
}

// Initialize the app when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const app = new UKDataCleanerApp();

    // Display file size limit info
    const fileSizeLimit = document.getElementById('fileSizeLimit');
    if (fileSizeLimit && app.browserInfo) {
        const browserText = app.browserInfo.hasDeviceMemory
            ? `${app.browserInfo.name} with ${app.browserInfo.memoryGB}GB RAM`
            : `${app.browserInfo.name} (conservative estimate)`;
        fileSizeLimit.textContent = `Recommended limit: ${app.maxFileSizeMB.toFixed(0)} MB (${browserText})`;
    }
});
