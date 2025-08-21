<script lang="ts">
    import { onMount } from "svelte";
    import { FileProcessor, type FileProcessingResult } from "$lib/fileProcessor";
    import { autoValidate, PhoneNumberValidator } from "$lib/validators";

    let fileInput: HTMLInputElement;
    let selectedFile: File | null = null;
    let isProcessing = false;
    let results: FileProcessingResult | null = null;
    let error: string | null = null;
    let supportedTypes: string[] = [];
    let phoneFormat: "international" | "uk" = "international";
    let testResult: any = null;
    let fileHeaders: string[] = [];
    let selectedFields: string[] = [];
    let showFieldSelection = false;
    let fileData: string[][] = [];

    const fileProcessor = new FileProcessor(phoneFormat);
    const phoneValidator = new PhoneNumberValidator(phoneFormat);

    // Quick test examples from phonecases.txt
    const quickTestExamples = [
        "07700 900123",
        "Mobile: 07700 900123",
        "📱+44 7700 900123",
        "07700 900123 x12",
        '"07700 900123"',
        "07700•900•123",
        "O7700 900123",
        "tel:07700900123",
        "+44 0 7700 900123",
    ];

    function testPhoneNumber(input: string) {
        if (!input.trim()) {
            testResult = null;
            return;
        }

        testResult = phoneValidator.validate(input);
    }

    onMount(() => {
        supportedTypes = fileProcessor.getSupportedFileTypes();
    });

    async function handleFileSelect(event: Event) {
        const target = event.target as HTMLInputElement;
        if (target.files && target.files.length > 0) {
            selectedFile = target.files[0];
            error = null;
            results = null;
            showFieldSelection = false;
            selectedFields = [];

            // Parse file headers to show field selection
            try {
                const text = await selectedFile.text();
                const lines = text.split("\n").filter((line) => line.trim());
                if (lines.length > 0) {
                    // Use proper CSV parsing for headers
                    fileHeaders = parseCSVLine(lines[0]);
                    // Parse all data rows properly
                    fileData = lines.map((line) => parseCSVLine(line));
                    showFieldSelection = true;
                }
            } catch (err) {
                error = "Could not read file headers";
            }
        }
    }

    function toggleFieldSelection(field: string) {
        if (selectedFields.includes(field)) {
            selectedFields = selectedFields.filter((f) => f !== field);
        } else {
            selectedFields = [...selectedFields, field];
        }
        // Force reactivity by reassigning the array
        selectedFields = [...selectedFields];
        console.log("Selected fields:", selectedFields, "Length:", selectedFields.length);
    }

    function selectAllFields() {
        selectedFields = [...fileHeaders];
    }

    function clearFieldSelection() {
        selectedFields = [];
    }

    // Proper CSV parsing function to handle quoted fields
    function parseCSVLine(line: string): string[] {
        const result: string[] = [];
        let current = "";
        let inQuotes = false;

        for (let i = 0; i < line.length; i++) {
            const char = line[i];

            if (char === '"') {
                inQuotes = !inQuotes;
            } else if (char === "," && !inQuotes) {
                result.push(current.trim());
                current = "";
            } else {
                current += char;
            }
        }

        result.push(current.trim());
        return result;
    }

    async function processFile() {
        if (!selectedFile || selectedFields.length === 0) return;

        isProcessing = true;
        error = null;
        results = null;

        try {
            // Process the original file but only validate selected columns
            // This preserves the original data structure for the cleaned export
            results = await fileProcessor.processFile(selectedFile, selectedFields);

            // No need to filter results here since FileProcessor now handles it
            // Just recalculate summary based on the processed results
            if (results) {
                let totalValid = 0;
                let totalInvalid = 0;
                let totalFixed = 0;

                results.processedRows.forEach((row) => {
                    row.validationResults.forEach((result) => {
                        if (result.detectedType === "header") return; // Skip header

                        if (result.isValid) {
                            totalValid++;
                            if (result.fixed && result.fixed !== result.value) {
                                totalFixed++;
                            }
                        } else {
                            totalInvalid++;
                        }
                    });
                });

                results.summary = {
                    totalValid,
                    totalInvalid,
                    totalFixed,
                    errors: results.summary.errors,
                };
            }
        } catch (err) {
            error = err instanceof Error ? err.message : "An error occurred while processing the file";
        } finally {
            isProcessing = false;
        }
    }

    async function exportResults(format: "csv" | "json" | "cleaned-csv") {
        if (!results) return;

        try {
            const blob = await fileProcessor.exportResults(results, format);
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            // Fix filename extension for cleaned-csv format and use original filename
            const fileExtension = format === "cleaned-csv" ? "csv" : format;
            const originalName = selectedFile?.name.replace(/\.[^/.]+$/, "") || "validation_results";
            const suffix = format === "cleaned-csv" ? "_cleaned" : format === "csv" ? "_validation_report" : "";
            a.download = `${originalName}${suffix}.${fileExtension}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        } catch (err) {
            error = "Failed to export results";
        }
    }

    function resetForm() {
        selectedFile = null;
        results = null;
        error = null;
        fileHeaders = [];
        selectedFields = [];
        showFieldSelection = false;
        fileData = [];
        if (fileInput) {
            fileInput.value = "";
        }
    }

    function updatePhoneFormat() {
        fileProcessor.updatePhoneFormat(phoneFormat);
    }

    function clearResults() {
        results = null;
        error = null;
        selectedFields = [];
        showFieldSelection = false;
    }

    function clearAllData() {
        clearResults();
        resetForm();
    }
</script>

<svelte:head>
    <title>File Data Validator</title>
    <meta name="description" content="Validate UK data formats including phone numbers, NI numbers, postcodes, and bank sort codes" />
</svelte:head>

<main class="container mx-auto px-4 py-8 max-w-6xl">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Data Validation Tool</h1>
            <p class="text-xl text-gray-600">Clean and validate your data with intelligent formatting detection</p>
        </div>

        <!-- File Upload Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                <svg class="w-6 h-6 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload Your File
            </h2>

            <div class="space-y-6">
                <!-- File Input -->
                <div>
                    <label for="file-input" class="block text-sm font-medium text-gray-700 mb-2">Select File</label>
                    <input
                        bind:this={fileInput}
                        id="file-input"
                        type="file"
                        accept=".csv,.xlsx,.txt"
                        on:change={handleFileSelect}
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                    />
                    <p class="mt-2 text-sm text-gray-500">Supported formats: CSV, Excel (.xlsx), and plain text files</p>
                </div>

                <!-- Phone Format Selector -->
                <div>
                    <fieldset>
                        <legend class="block text-sm font-medium text-gray-700 mb-2">Phone Number Format</legend>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" bind:group={phoneFormat} value="international" on:change={updatePhoneFormat} class="mr-2 text-blue-600 focus:ring-blue-500" />
                                <span class="text-sm text-gray-700">International (+44)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" bind:group={phoneFormat} value="uk" on:change={updatePhoneFormat} class="mr-2 text-blue-600 focus:ring-blue-500" />
                                <span class="text-sm text-gray-700">UK (0)</span>
                            </label>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Choose how phone numbers should be formatted in the results</p>
                    </fieldset>
                </div>

                <!-- File Info -->
                {#if selectedFile}
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-blue-900">{selectedFile.name}</p>
                                <p class="text-sm text-blue-700">
                                    Size: {(selectedFile.size / 1024).toFixed(1)} KB | Type: {selectedFile.type || "Unknown"}
                                </p>
                            </div>
                            <button on:click={resetForm} class="text-blue-600 hover:text-blue-800 text-sm font-medium">Remove</button>
                        </div>
                    </div>
                {/if}

                <!-- Field Selection -->
                {#if showFieldSelection}
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-3">
                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Select Fields to Clean
                        </h3>
                        <p class="text-sm text-gray-600 mb-4">Choose which columns you want us to validate and clean:</p>

                        <!-- Field Selection Controls -->
                        <div class="flex gap-2 mb-4">
                            <button on:click={selectAllFields} class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition-colors"> Select All </button>
                            <button on:click={clearFieldSelection} class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-200 transition-colors"> Clear All </button>
                            <button
                                on:click={() => {
                                    selectedFields = fileHeaders.filter((field) => /phone|mobile|tel|number|ni|insurance|postcode|sort|code|address/i.test(field));
                                }}
                                class="px-3 py-1 bg-green-100 text-green-700 rounded text-sm hover:bg-green-200 transition-colors"
                            >
                                Auto-Select Cleanable
                            </button>
                        </div>

                        <!-- Field Checkboxes -->
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            {#each fileHeaders as field}
                                {@const isLikelyCleanable = /phone|mobile|tel|number|ni|insurance|postcode|sort|code|address/i.test(field)}
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        checked={selectedFields.includes(field)}
                                        on:change={() => toggleFieldSelection(field)}
                                        class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                    />
                                    <span class="text-sm text-gray-700">{field}</span>
                                    {#if isLikelyCleanable}
                                        <svg class="w-4 h-4 text-blue-600 bg-blue-100 p-0.5 rounded" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                            ></path>
                                        </svg>
                                    {/if}
                                </label>
                            {/each}
                        </div>

                        <!-- Smart Suggestions -->
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <p class="text-sm text-blue-800">
                                <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                    ></path>
                                </svg>
                                <strong>Smart Suggestions:</strong> Fields with the
                                <svg class="w-3 h-3 inline mx-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                                    ></path>
                                </svg>
                                icon are likely to contain data that can be cleaned (phone numbers, NI numbers, postcodes, addresses, etc.)
                            </p>
                        </div>

                        {#if selectedFields.length === 0}
                            <p class="text-sm text-orange-600 mt-3">⚠️ Please select at least one field to clean</p>
                        {:else}
                            <p class="text-sm text-green-600 mt-3">✅ {selectedFields.length} field(s) selected for cleaning</p>
                        {/if}

                        <!-- Debug info -->
                        <div class="mt-2 p-2 bg-gray-100 rounded text-xs text-gray-600">
                            <strong>Debug:</strong> Selected fields: [{selectedFields.join(", ")}] | Count: {selectedFields.length} | Button disabled: {!selectedFile ||
                                selectedFields.length === 0 ||
                                isProcessing}
                        </div>
                    </div>
                {/if}

                <!-- Process Button -->
                <button
                    on:click={processFile}
                    disabled={!selectedFile || selectedFields.length === 0 || isProcessing}
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-medium hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
                >
                    {isProcessing ? "Processing..." : "Clean Selected Fields"}
                </button>

                <!-- Error Display -->
                {#if error}
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Error</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>{error}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        </div>

        <!-- Validation Results Section - Moved up for prominence -->
        {#if results}
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    <svg class="w-6 h-6 inline mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                        ></path>
                    </svg>
                    Validation Results - Selected Fields Only
                </h2>
                <p class="text-sm text-gray-600 mb-4">Showing results for: <span class="font-medium">{selectedFields.join(", ")}</span></p>

                <!-- Export Buttons -->
                <div class="flex flex-wrap gap-3 mb-6">
                    <button on:click={() => exportResults("cleaned-csv")} class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                        </svg>
                        Export Cleaned CSV
                    </button>
                    <button on:click={() => exportResults("csv")} class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                        </svg>
                        Export Validation Report
                    </button>
                    <button on:click={() => exportResults("json")} class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                            ></path>
                        </svg>
                        Export JSON
                    </button>
                    <button on:click={clearResults} class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            ></path>
                        </svg>
                        Clear Data
                    </button>
                </div>

                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-blue-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-blue-800">{results.totalRows}</div>
                        <div class="text-blue-600">Total Rows</div>
                    </div>
                    <div class="bg-green-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-green-800">{results.summary.totalValid}</div>
                        <div class="text-green-600">Valid Data</div>
                    </div>
                    <div class="bg-yellow-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-yellow-800">{results.summary.totalFixed}</div>
                        <div class="text-yellow-600">Cleaned Data</div>
                    </div>
                    <div class="bg-red-100 rounded-lg p-4 text-center">
                        <div class="text-2xl font-bold text-red-800">{results.summary.totalInvalid}</div>
                        <div class="text-red-600">Invalid Data</div>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Row</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Column</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Original Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cleaned Value</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {#each results.processedRows as row}
                                {#each row.validationResults as result}
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {row.rowNumber}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="font-medium text-gray-700">{result.column}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <code class="bg-gray-100 px-2 py-1 rounded text-xs">{result.value}</code>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {#if result.isValid}
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800"> Valid </span>
                                            {:else}
                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800"> Invalid </span>
                                            {/if}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {#if result.detectedType === "phone_number"}
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                                        ></path>
                                                    </svg>
                                                    Phone
                                                {:else if result.detectedType === "ni_number"}
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 12a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 12a2 2 0 100-4 2 2 0 000 4z"
                                                        ></path>
                                                    </svg>
                                                    NI Number
                                                {:else if result.detectedType === "postcode"}
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                                        ></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    Postcode
                                                {:else if result.detectedType === "sort_code"}
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"
                                                        ></path>
                                                    </svg>
                                                    Sort Code
                                                {:else}
                                                    {result.detectedType}
                                                {/if}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {#if result.fixed}
                                                <code class="bg-green-100 px-2 py-1 rounded text-xs text-green-800">{result.fixed}</code>
                                            {:else}
                                                <span class="text-gray-400">-</span>
                                            {/if}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {#if result.error}
                                                <span class="text-red-600 text-xs">{result.error}</span>
                                            {:else}
                                                <span class="text-gray-400">-</span>
                                            {/if}
                                        </td>
                                    </tr>
                                {/each}
                            {/each}
                        </tbody>
                    </table>
                </div>
            </div>
        {/if}

        <!-- Compact Testing Section - Moved down and made more compact -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                <svg class="w-6 h-6 inline mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"
                    ></path>
                </svg>
                Test Phone Number Cleaning
            </h2>

            <!-- Quick Examples in a compact grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- What We Can Clean -->
                <div class="bg-green-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-green-800 mb-3">
                        <svg class="w-5 h-5 inline mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        What We Can Clean Automatically
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div><strong>Labels & Icons:</strong> "Mobile: 07700 900123" → "+44 7700 900123"</div>
                        <div><strong>Extensions:</strong> "07700 900123 x12" → "+44 7700 900123"</div>
                        <div><strong>Weird Separators:</strong> "07700-900-123" → "+44 7700 900123"</div>
                        <div><strong>Quotes & Wrapping:</strong> `"07700 900123"` → "+44 7700 900123"</div>
                    </div>
                </div>

                <!-- What Requires Manual Correction -->
                <div class="bg-red-50 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-red-800 mb-3">
                        <svg class="w-5 h-5 inline mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                            ></path>
                        </svg>
                        What Requires Manual Correction
                    </h3>
                    <div class="space-y-2 text-sm">
                        <div><strong>Look-alike Characters:</strong> "07780 900123" (0 for 6)</div>
                        <div><strong>Non-ASCII Digits:</strong> Full-width or Arabic-Indic numerals</div>
                        <div><strong>Protocol Links:</strong> "tel:07700900123"</div>
                        <div><strong>Malformed Country Codes:</strong> "+44 0 7700 900123"</div>
                    </div>
                </div>
            </div>

            <!-- Interactive Testing - More compact -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Interactive Testing</h3>
                <p class="text-gray-600 mb-3 text-sm">Test any phone number format to see how our system handles it:</p>

                <div class="flex space-x-3 mb-3">
                    <input
                        type="text"
                        placeholder="Enter phone number to test..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                        on:input={(e) => testPhoneNumber((e.target as HTMLInputElement).value)}
                    />
                    <button on:click={() => testPhoneNumber("")} class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors text-sm"> Clear </button>
                </div>

                {#if testResult}
                    <div class="bg-white rounded-lg p-3 border text-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-medium text-gray-800">Test Result:</span>
                            {#if testResult.isValid}
                                <span class="text-green-600 text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Valid & Cleaned
                                </span>
                            {:else}
                                <span class="text-red-600 text-sm font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cannot Process
                                </span>
                            {/if}
                        </div>
                        <div class="space-y-1 text-sm">
                            <div><strong>Input:</strong> <code class="bg-gray-100 px-1 py-0.5 rounded">{testResult.value}</code></div>
                            {#if testResult.fixed}
                                <div><strong>Cleaned:</strong> <code class="bg-green-100 px-1 py-0.5 rounded">{testResult.fixed}</code></div>
                            {/if}
                            {#if testResult.error}
                                <div><strong>Issue:</strong> <span class="text-red-600">{testResult.error}</span></div>
                            {/if}
                        </div>
                    </div>
                {/if}

                <div class="mt-3">
                    <p class="text-sm text-gray-600 mb-2">Quick test examples:</p>
                    <div class="flex flex-wrap gap-2">
                        {#each quickTestExamples as example}
                            <button on:click={() => testPhoneNumber(example)} class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded hover:bg-blue-200 transition-colors">
                                {example}
                            </button>
                        {/each}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Display -->
    {#if error}
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Error</h3>
                    <p class="text-sm text-red-700 mt-1">{error}</p>
                </div>
            </div>
        </div>
    {/if}

    <!-- Features Section -->
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3" style="width: 32px; height: 32px;">
                <svg class="text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Smart Validation</h3>
            <p class="text-gray-600">Automatically detects and validates UK phone numbers, NI numbers, postcodes, and bank sort codes.</p>
        </div>

        <div class="text-center">
            <div class="bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3" style="width: 32px; height: 32px;">
                <svg class="text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
                    />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Auto-Fix</h3>
            <p class="text-gray-600">Intelligently fixes common formatting issues and provides clear explanations of what was corrected.</p>
        </div>

        <div class="text-center">
            <div class="bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3" style="width: 32px; height: 32px;">
                <svg class="text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                    />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-800 mb-2">Export Results</h3>
            <p class="text-gray-600">Download your validation results in CSV or JSON format for further analysis and record-keeping.</p>
        </div>
    </div>
</main>

<!-- Privacy Footer -->
<footer class="bg-gray-50 border-t border-gray-200 mt-16">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-2">🔒 Your data is processed locally and never transmitted to our servers</p>
            <div class="space-x-4 text-sm">
                <a href="/validation-rules" class="text-blue-600 hover:text-blue-800 underline">Validation Rules</a>
                <span class="text-gray-400">•</span>
                <a href="/privacy" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a>
                <span class="text-gray-400">•</span>
                <span class="text-gray-600">GDPR Compliant</span>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Add any custom styles here */
</style>
