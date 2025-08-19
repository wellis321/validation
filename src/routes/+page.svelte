<script lang="ts">
    import { onMount } from "svelte";
    import { FileProcessor, type FileProcessingResult } from "$lib/fileProcessor";
    import { autoValidate } from "$lib/validators";

    let fileInput: HTMLInputElement;
    let selectedFile: File | null = null;
    let isProcessing = false;
    let results: FileProcessingResult | null = null;
    let error: string | null = null;
    let supportedTypes: string[] = [];
    let phoneFormat: "international" | "uk" = "international";

    const fileProcessor = new FileProcessor(phoneFormat);

    onMount(() => {
        supportedTypes = fileProcessor.getSupportedFileTypes();
    });

    async function handleFileSelect(event: Event) {
        const target = event.target as HTMLInputElement;
        if (target.files && target.files.length > 0) {
            selectedFile = target.files[0];
            error = null;
            results = null;
        }
    }

    async function processFile() {
        if (!selectedFile) return;

        isProcessing = true;
        error = null;
        results = null;

        try {
            results = await fileProcessor.processFile(selectedFile);
        } catch (err) {
            error = err instanceof Error ? err.message : "An error occurred while processing the file";
        } finally {
            isProcessing = false;
        }
    }

    async function exportResults(format: "csv" | "json") {
        if (!results) return;

        try {
            const blob = await fileProcessor.exportResults(results, format);
            const url = URL.createObjectURL(blob);
            const a = document.createElement("a");
            a.href = url;
            a.download = `validation_results.${format}`;
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
        if (fileInput) {
            fileInput.value = "";
        }
    }

    function updatePhoneFormat() {
        fileProcessor.setPhoneFormat(phoneFormat);
        // Reset results when format changes
        results = null;
    }

    function clearAllData() {
        selectedFile = null;
        results = null;
        error = null;
        if (fileInput) {
            fileInput.value = "";
        }
        // Force garbage collection hint (if available in dev environment)
        if ("gc" in window && typeof (window as any).gc === "function") {
            (window as any).gc();
        }
    }
</script>

<svelte:head>
    <title>File Data Validator</title>
    <meta name="description" content="Validate UK data formats including phone numbers, NI numbers, postcodes, and bank sort codes" />
</svelte:head>

<main class="container mx-auto px-4 py-8 max-w-6xl">
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">File Data Validator</h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Upload your CSV, Excel, or text files to validate UK data formats including phone numbers, National Insurance numbers, postcodes, and bank sort codes. Get instant feedback on what's valid,
            what can be fixed, and what needs attention.
        </p>

        <!-- Privacy Notice -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 max-w-4xl mx-auto">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <div class="ml-3 text-left">
                    <h3 class="text-sm font-medium text-green-800">🔒 Privacy Protected</h3>
                    <p class="text-sm text-green-700 mt-1">
                        Your data is processed <strong>entirely in your browser</strong> and never uploaded to our servers. No data is stored, logged, or transmitted. Files and results remain on your device
                        only.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- File Upload Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Upload Your File</h2>

        <div class="space-y-6">
            <!-- File Input -->
            <div>
                <label for="file-input" class="block text-sm font-medium text-gray-700 mb-2"> Select File </label>
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
                        <button on:click={resetForm} class="text-blue-600 hover:text-blue-800 text-sm font-medium"> Remove </button>
                    </div>
                </div>
            {/if}

            <!-- Process Button -->
            <button
                on:click={processFile}
                disabled={!selectedFile || isProcessing}
                class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
            >
                {isProcessing ? "Processing..." : "Validate File"}
            </button>
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

    <!-- Results Section -->
    {#if results}
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Validation Results</h2>
                <div class="space-x-3">
                    <button on:click={() => exportResults("csv")} class="bg-green-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-green-700 transition-colors"> Export CSV </button>
                    <button on:click={() => exportResults("json")} class="bg-purple-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-purple-700 transition-colors"> Export JSON </button>
                    <button on:click={clearAllData} class="bg-red-600 text-white py-2 px-4 rounded-lg font-medium hover:bg-red-700 transition-colors"> Clear Data </button>
                </div>
            </div>

            <!-- Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">{results.totalRows}</p>
                    <p class="text-sm text-blue-700">Total Rows</p>
                </div>
                <div class="bg-green-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">{results.summary.totalValid}</p>
                    <p class="text-sm text-green-700">Valid Data</p>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-yellow-600">{results.summary.totalFixed}</p>
                    <p class="text-sm text-yellow-700">Fixed Data</p>
                </div>
                <div class="bg-red-50 rounded-lg p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">{results.summary.totalInvalid}</p>
                    <p class="text-sm text-red-700">Invalid Data</p>
                </div>
            </div>

            <!-- Results Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Row </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Column </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Original Value </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Status </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Detected Type </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Fixed Value </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"> Notes </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {#each results.processedRows as row}
                            {#each row.validationResults as result}
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {row.rowNumber}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {result.column}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {result.value}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {#if result.isValid}
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800"> Valid </span>
                                        {:else}
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800"> Invalid </span>
                                        {/if}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {result.detectedType}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {result.fixed || "-"}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {result.error || "-"}
                                    </td>
                                </tr>
                            {/each}
                        {/each}
                    </tbody>
                </table>
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
                <a href="/privacy" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a>
                <span class="text-gray-400">•</span>
                <span class="text-gray-600">GDPR Compliant</span>
                <span class="text-gray-400">•</span>
                <span class="text-gray-600">No Data Storage</span>
            </div>
        </div>
    </div>
</footer>

<style>
    /* Add any custom styles here */
</style>
