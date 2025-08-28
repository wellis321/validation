<script lang="ts">
    import { onMount } from "svelte";
    import { FileProcessor, type FileProcessingResult } from "$lib/fileProcessor";
    import { PhoneNumberValidator } from "$lib/validators";

    let fileInput: HTMLInputElement;
    let selectedFile: File | null = null;
    let isProcessing = false;
    let results: FileProcessingResult | null = null;
    let error: string | null = null;
    let phoneFormat: "international" | "uk" = "international";
    let testResult: any = null;
    let fileHeaders: string[] = [];
    let selectedFields: string[] = [];
    let showFieldSelection = false;
    let fileData: string[][] = [];

    const fileProcessor = new FileProcessor(phoneFormat);
    const phoneValidator = new PhoneNumberValidator(phoneFormat);

    // Simple examples that show the value
    const examples = [
        { before: "07700 900123", after: "+44 7700 900123", type: "Phone Number" },
        { before: "ab123cd", after: "AB12 3CD", type: "Postcode" },
        { before: "123456", after: "12-34-56", type: "Sort Code" },
        { before: "ab 12 34 56 c", after: "AB123456C", type: "NI Number" },
    ];

    function testPhoneNumber(input: string) {
        if (!input.trim()) {
            testResult = null;
            return;
        }
        testResult = phoneValidator.validate(input);
    }

    onMount(() => {
        // Initialize
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
            // Ensure phone format is synchronized before processing
            updatePhoneFormat();
            // Process the file with selected columns
            results = await fileProcessor.processFile(selectedFile, selectedFields);
        } catch (err) {
            error = err instanceof Error ? err.message : "An error occurred while processing the file";
        } finally {
            isProcessing = false;
        }
    }

    async function exportResults(format: "csv" | "json" | "cleaned-csv" | "excel") {
        if (!results) return;

        try {
            const blob = await fileProcessor.exportResults(results, format);
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            const fileExtension = format === "cleaned-csv" ? "csv" : format === "excel" ? "csv" : format;
            const originalName = selectedFile?.name.replace(/\.[^/.]+$/, "") || "validation_results";
            const suffix = format === "cleaned-csv" ? "_cleaned" : format === "csv" ? "_validation_report" : format === "excel" ? "_excel_friendly" : "";
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
        // Also update the phone validator to ensure consistency
        phoneValidator.setOutputFormat(phoneFormat);
    }

    function clearResults() {
        results = null;
        error = null;
    }
</script>

<svelte:head>
    <title>UK Data Cleaner - Clean Phone Numbers, Postcodes & More</title>
    <meta name="description" content="Instantly clean and format UK data including phone numbers, postcodes, NI numbers, and bank sort codes. Upload your CSV and get clean data back." />
</svelte:head>

<main class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-16 text-center">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-5xl md:text-6xl font-bold text-gray-900 mb-6">
                Clean Your UK Data
                <span class="text-blue-600">Instantly</span>
            </h1>
            <p class="text-xl md:text-2xl text-gray-600 mb-8 leading-relaxed">
                Upload your CSV file and we'll automatically clean and format your UK phone numbers, postcodes, NI numbers, and bank sort codes. No more messy data.
            </p>

            <!-- CTA Button -->
            <div class="mb-12">
                <button
                    on:click={() => fileInput?.click()}
                    class="bg-blue-600 hover:bg-blue-700 text-white text-lg px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105"
                >
                    <svg class="w-6 h-6 inline mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    Upload Your File Now
                </button>
            </div>

            <!-- Examples Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                {#each examples as example}
                    <div class="bg-white rounded-xl p-6 shadow-lg">
                        <div class="text-sm text-gray-500 mb-2">{example.type}</div>
                        <div class="text-lg font-mono text-gray-400 mb-2">{example.before}</div>
                        <div class="text-lg font-mono text-green-600 font-semibold">{example.after}</div>
                    </div>
                {/each}
            </div>
        </div>
    </div>

    <!-- How It Works -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">How It Works</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">1</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Upload</h3>
                    <p class="text-gray-600">Drop your CSV file with messy UK data</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">2</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Process</h3>
                    <p class="text-gray-600">We automatically detect and clean your data</p>
                </div>
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-blue-600">3</span>
                    </div>
                    <h3 class="text-xl font-semibold mb-3">Download</h3>
                    <p class="text-gray-600">Get your clean, formatted data back</p>
                </div>
            </div>
        </div>
    </div>

    <!-- File Upload Section -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Ready to Clean Your Data?</h2>

                <!-- Hidden file input -->
                <input bind:this={fileInput} type="file" accept=".csv,.xlsx,.txt" on:change={handleFileSelect} class="hidden" />

                <!-- File Upload Area -->
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center mb-6 hover:border-blue-400 transition-colors">
                    {#if !selectedFile}
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="text-lg text-gray-600 mb-2">Drop your file here or click to browse</p>
                        <p class="text-sm text-gray-500">Supports CSV, Excel, and text files</p>
                        <button on:click={() => fileInput?.click()} class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors"> Choose File </button>
                    {:else}
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center justify-center mb-2">
                                <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span class="text-lg font-semibold text-green-800">File Selected!</span>
                            </div>
                            <p class="text-green-700 mb-3">{selectedFile.name}</p>
                            <button on:click={resetForm} class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors text-sm"> Choose Different File </button>
                        </div>
                    {/if}
                </div>

                <!-- Field Selection -->
                {#if showFieldSelection}
                    <div class="bg-blue-50 rounded-xl p-6 mb-6 border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-4 text-center">
                            <svg class="w-5 h-5 inline mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Select Fields to Clean
                        </h3>
                        <p class="text-sm text-blue-700 mb-4 text-center">Choose which columns you want us to validate and clean:</p>

                        <!-- Field Selection Controls -->
                        <div class="flex gap-2 mb-4 justify-center">
                            <button on:click={selectAllFields} class="px-3 py-1 bg-blue-100 text-blue-700 rounded text-sm hover:bg-blue-200 transition-colors"> Select All </button>
                            <button on:click={clearFieldSelection} class="px-3 py-1 bg-gray-100 text-gray-700 rounded text-sm hover:bg-gray-400 transition-colors"> Clear All </button>
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
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-4">
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
                        <div class="text-center p-3 bg-blue-100 rounded-lg border border-blue-200">
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
                                icon are likely to contain data that can be cleaned
                            </p>
                        </div>

                        {#if selectedFields.length === 0}
                            <p class="text-sm text-orange-600 mt-3 text-center">⚠️ Please select at least one field to clean</p>
                        {:else}
                            <p class="text-sm text-green-600 mt-3 text-center">✅ {selectedFields.length} field(s) selected for cleaning</p>
                        {/if}
                    </div>
                {/if}

                <!-- Phone Format Option -->
                <div class="text-center mb-6">
                    <p class="text-sm text-gray-600 mb-2">Phone number format preference:</p>
                    <div class="flex justify-center space-x-4">
                        <label class="flex items-center">
                            <input type="radio" bind:group={phoneFormat} value="international" on:change={updatePhoneFormat} class="mr-2 text-blue-600 focus:ring-blue-500" />
                            <span class="text-sm text-gray-700">International (+44)</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" bind:group={phoneFormat} value="uk" on:change={updatePhoneFormat} class="mr-2 text-blue-600 focus:ring-blue-500" />
                            <span class="text-sm text-gray-700">UK (0)</span>
                        </label>
                    </div>
                </div>

                <!-- Process Button -->
                {#if showFieldSelection && selectedFields.length > 0}
                    <button
                        on:click={processFile}
                        disabled={isProcessing}
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-medium disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors text-lg"
                    >
                        {isProcessing ? "Processing..." : "Clean My Data"}
                    </button>
                {/if}
            </div>
        </div>
    </div>

    <!-- Results Section - Now positioned right after the upload section -->
    {#if results}
        <div class="bg-white py-16">
            <div class="container mx-auto px-4 max-w-6xl">
                <div class="bg-green-50 rounded-2xl p-8 border border-green-200">
                    <h2 class="text-2xl font-bold text-green-800 mb-6 text-center">🎉 Your Data Has Been Cleaned!</h2>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="bg-white rounded-lg p-4 text-center shadow">
                            <div class="text-2xl font-bold text-blue-600">{results.totalRows}</div>
                            <div class="text-blue-600 text-sm">Total Rows</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center shadow">
                            <div class="text-2xl font-bold text-green-600">{results.summary.totalValid}</div>
                            <div class="text-green-600 text-sm">Valid Data</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center shadow">
                            <div class="text-2xl font-bold text-yellow-600">{results.summary.totalFixed}</div>
                            <div class="text-yellow-600 text-sm">Cleaned Data</div>
                        </div>
                        <div class="bg-white rounded-lg p-4 text-center shadow">
                            <div class="text-2xl font-bold text-red-600">{results.summary.totalInvalid}</div>
                            <div class="text-red-600 text-sm">Issues Found</div>
                        </div>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-wrap gap-4 justify-center mb-6">
                        <button on:click={() => exportResults("cleaned-csv")} class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium transition-colors flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                ></path>
                            </svg>
                            Download Cleaned CSV
                        </button>
                        <button on:click={() => exportResults("csv")} class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"> Download Report </button>
                        <button on:click={() => exportResults("excel")} class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            Download Excel-Friendly CSV
                        </button>
                        <button on:click={() => exportResults("json")} class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"> Download JSON </button>
                        <button on:click={clearResults} class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors"> Process New File </button>
                    </div>

                    <!-- Sample Results -->
                    <div class="bg-white rounded-lg p-6 shadow">
                        <h3 class="text-lg font-semibold mb-4">Sample of What We Cleaned:</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Row</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Column</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">Before</th>
                                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-500">After</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    {#each results.processedRows.slice(0, 5) as row}
                                        {#each row.validationResults.slice(0, 2) as result}
                                            {#if result.fixed && result.fixed !== result.value}
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-4 py-2 text-sm text-gray-500">{row.rowNumber}</td>
                                                    <td class="px-4 py-2 text-sm font-medium">{result.column}</td>
                                                    <td class="px-4 py-2 text-sm"><code class="bg-gray-100 px-2 py-1 rounded">{result.value}</code></td>
                                                    <td class="px-4 py-2 text-sm"><code class="bg-green-100 px-2 py-1 rounded text-green-800">{result.fixed}</code></td>
                                                </tr>
                                            {/if}
                                        {/each}
                                    {/each}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {/if}

    <!-- Error Display -->
    {#if error}
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mx-4 mb-8 max-w-4xl mx-auto">
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

    <!-- Test Section -->
    <div class="bg-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-8">Try It Out</h2>
            <div class="bg-gray-50 rounded-2xl p-8">
                <p class="text-center text-gray-600 mb-6">Test how we clean phone numbers:</p>

                <div class="flex space-x-4 mb-4">
                    <input
                        type="text"
                        placeholder="Enter a phone number to test..."
                        class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        on:input={(e) => testPhoneNumber((e.target as HTMLInputElement).value)}
                    />
                </div>

                {#if testResult}
                    <div class="bg-white rounded-lg p-6 shadow">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-lg font-semibold">Test Result:</span>
                            {#if testResult.isValid}
                                <span class="text-green-600 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Valid & Cleaned
                                </span>
                            {:else}
                                <span class="text-red-600 font-medium flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cannot Process
                                </span>
                            {/if}
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="text-sm text-gray-500 mb-1">Input:</div>
                                <code class="bg-gray-100 px-3 py-2 rounded text-sm">{testResult.value}</code>
                            </div>
                            {#if testResult.fixed}
                                <div>
                                    <div class="text-sm text-gray-500 mb-1">Cleaned:</div>
                                    <code class="bg-green-100 px-3 py-2 rounded text-sm text-green-800">{testResult.fixed}</code>
                                </div>
                            {/if}
                        </div>
                    </div>
                {/if}

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-3">Quick test examples:</p>
                    <div class="flex flex-wrap gap-2 justify-center">
                        <button on:click={() => testPhoneNumber("07700 900123")} class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200 transition-colors"> 07700 900123 </button>
                        <button on:click={() => testPhoneNumber("Mobile: 07700 900123")} class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200 transition-colors">
                            Mobile: 07700 900123
                        </button>
                        <button on:click={() => testPhoneNumber("07700-900-123")} class="text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded hover:bg-blue-200 transition-colors">
                            07700-900-123
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features -->
    <div class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-900 mb-12">What We Clean</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-6xl mx-auto">
                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="bg-blue-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Phone Numbers</h3>
                    <p class="text-gray-600 text-sm">Format UK mobile and landline numbers consistently</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Postcodes</h3>
                    <p class="text-gray-600 text-sm">Validate and format UK postcodes correctly</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="bg-purple-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 12a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 12a2 2 0 100-4 2 2 0 000 4z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">NI Numbers</h3>
                    <p class="text-gray-600 text-sm">Clean National Insurance number formats</p>
                </div>

                <div class="bg-white rounded-xl p-6 text-center shadow-lg">
                    <div class="bg-yellow-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">Sort Codes</h3>
                    <p class="text-gray-600 text-sm">Format bank sort codes consistently</p>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-white py-12">
    <div class="container mx-auto px-4 text-center">
        <p class="text-lg mb-4">🔒 Your data is processed locally and never sent to our servers</p>
        <div class="space-x-6 text-sm text-gray-400">
            <a href="/validation-rules" class="hover:text-white transition-colors">Validation Rules</a>
            <span>•</span>
            <a href="/privacy" class="hover:text-white transition-colors">Privacy Policy</a>
            <span>•</span>
            <span>GDPR Compliant</span>
        </div>
    </div>
</footer>
