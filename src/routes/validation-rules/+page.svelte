<script lang="ts">
    import { PhoneNumberValidator, NINumberValidator, PostcodeValidator, SortCodeValidator } from "$lib/validators";

    // Sample data for demonstration
    const sampleData = {
        phone: ["+44 7700 900123", "07700 900123", "0044 7700 900123", "+44 (0) 7700 900123", "7700 900123"],
        ni: ["AB123456C", "AB 123456 C", "12345678"],
        postcode: ["M1 1AA", "M11AA", "SW1A 1AA", "SW1A1AA"],
        sortCode: ["12-34-56", "123456", "00-00-00"],
    };

    // Validation rules data structure
    const validationRules = {
        phone_numbers: {
            title: "Phone Numbers",
            icon: "phone",
            description: "UK mobile and landline phone number validation with automatic formatting",
            intro: "We take your phone number input and automatically check it against UK phone number standards. Our system detects the type of number, validates the format, and applies automatic fixes to ensure consistency.",
            whatWeCheck: [
                "Number length and structure",
                "Country code format (+44)",
                "UK domestic format (0)",
                "Mobile vs landline patterns",
                "Area code validity",
                "Spacing and formatting consistency",
            ],
            automaticFixes: [
                {
                    name: "Format Standardization",
                    description: "Convert between international (+44) and UK (0) formats",
                    examples: ["07700 900123 → +44 7700 900123", "+44 7700 900123 → 07700 900123"],
                },
                {
                    name: "Country Code Correction",
                    description: "Fix missing or incorrect country codes",
                    examples: ["7700 900123 → +44 7700 900123", "0044 7700 900123 → +44 7700 900123"],
                },
                {
                    name: "Spacing and Punctuation",
                    description: "Standardize spacing and remove unnecessary characters",
                    examples: ["+44 (0) 7700 900123 → +44 7700 900123", "07700-900-123 → 07700 900123", "07700.900.123 → 07700 900123"],
                },
                {
                    name: "Area Code Validation",
                    description: "Verify and format area codes correctly",
                    examples: ["02079460958 → 020 7946 0958", "0113 123 4567 → 0113 123 4567"],
                },
            ],
            supportedFormats: [
                {
                    type: "Mobile Numbers",
                    pattern: "7xxxxxxxxx",
                    examples: ["07700 900123", "7700 900123", "+44 7700 900123"],
                    description: "10-digit numbers starting with 7 (mobile phones)",
                },
                {
                    type: "Landline Numbers",
                    pattern: "0xxxxxxxxx",
                    examples: ["020 7946 0958", "02079460958", "+44 20 7946 0958"],
                    description: "11-digit numbers starting with 0 (landlines)",
                },
                {
                    type: "International Format",
                    pattern: "+44 xxxxxxxxxx",
                    examples: ["+44 7700 900123", "+44 20 7946 0958"],
                    description: "Numbers with +44 country code prefix",
                },
            ],
            discoveredFormats: [
                {
                    format: "+44 (0) xxxxxxxxxx",
                    description: "International format with redundant (0) - commonly used but incorrect",
                    status: "Can fix - removes (0) and standardizes to +44 xxxxxxxxxx",
                    dateAdded: "2024-08-19",
                },
                {
                    format: "0044 xxxxxxxxxx",
                    description: "International format with 00 prefix instead of +",
                    status: "Can fix - converts to +44 xxxxxxxxxx",
                    dateAdded: "2024-08-19",
                },
            ],
        },
        national_insurance: {
            title: "National Insurance Numbers",
            icon: "id-card",
            description: "UK National Insurance number validation and formatting",
            intro: "We validate UK National Insurance numbers by checking their format structure and applying automatic corrections for common issues.",
            whatWeCheck: ["Format structure (2 letters + 6-8 digits + optional letter)", "Letter and digit combinations", "Spacing and formatting", "Case sensitivity"],
            automaticFixes: [
                {
                    name: "Prefix Addition",
                    description: "Add missing prefix letters when only digits are provided",
                    examples: ["12345678 → AB12345678", "123456789 → AB123456789"],
                },
                {
                    name: "Format Standardization",
                    description: "Standardize spacing and convert to uppercase",
                    examples: ["ab 123456 c → AB 123456 C", "ab123456c → AB 123456 C"],
                },
            ],
            supportedFormats: [
                {
                    type: "Standard Format",
                    pattern: "AB123456C",
                    examples: ["AB123456C", "AB 123456 C", "ab123456c"],
                    description: "2 letters + 6 digits + 1 letter",
                },
                {
                    type: "Extended Format",
                    pattern: "AB12345678",
                    examples: ["AB12345678", "AB 123456 78"],
                    description: "2 letters + 8 digits",
                },
            ],
            discoveredFormats: [],
        },
        postcodes: {
            title: "UK Postcodes",
            icon: "map-pin",
            description: "UK postcode validation with automatic formatting",
            intro: "We validate UK postcodes by checking their structure and applying automatic formatting corrections.",
            whatWeCheck: ["Area code format (1-2 letters)", "District code (1-2 digits)", "Sector code (1 letter)", "Unit code (2 letters)", "Spacing and formatting"],
            automaticFixes: [
                {
                    name: "Spacing Correction",
                    description: "Add proper spacing between postcode components",
                    examples: ["M11AA → M1 1AA", "SW1A1AA → SW1A 1AA"],
                },
                {
                    name: "Format Standardization",
                    description: "Standardize format and convert to uppercase",
                    examples: ["m1 1aa → M1 1AA", "sw1a 1aa → SW1A 1AA"],
                },
            ],
            supportedFormats: [
                {
                    type: "Standard Postcode",
                    pattern: "A9 9AA",
                    examples: ["M1 1AA", "B33 8TH"],
                    description: "1 letter + 1 digit + space + 1 digit + 2 letters",
                },
                {
                    type: "London Postcode",
                    pattern: "A9A 9AA",
                    examples: ["SW1A 1AA", "W1A 1AA"],
                    description: "1 letter + 1 digit + 1 letter + space + 1 digit + 2 letters",
                },
            ],
            discoveredFormats: [],
        },
        sort_codes: {
            title: "Bank Sort Codes",
            icon: "building-library",
            description: "UK bank sort code validation and formatting",
            intro: "We validate UK bank sort codes by checking their digit structure and applying automatic formatting.",
            whatWeCheck: ["Exactly 6 digits", "Digit combinations", "Format consistency", "Dash placement"],
            automaticFixes: [
                {
                    name: "Format Standardization",
                    description: "Standardize dash format and remove extra characters",
                    examples: ["123456 → 12-34-56", "12 34 56 → 12-34-56"],
                },
                {
                    name: "Extra Zero Removal",
                    description: "Remove unnecessary leading zeros",
                    examples: ["001234 → 12-34-56", "000123 → 12-34-56"],
                },
            ],
            supportedFormats: [
                {
                    type: "Standard Format",
                    pattern: "xx-xx-xx",
                    examples: ["12-34-56", "23-45-67"],
                    description: "6 digits with dashes between pairs",
                },
                {
                    type: "Compact Format",
                    pattern: "xxxxxx",
                    examples: ["123456", "234567"],
                    description: "6 digits without separators",
                },
            ],
            discoveredFormats: [],
        },
    };

    // Future data types that can be added
    const futureDataTypes = [
        {
            name: "Email Addresses",
            icon: "envelope",
            description: "Email validation with domain checking and format verification",
            status: "planned",
        },
        {
            name: "UK Driving Licenses",
            icon: "truck",
            description: "UK driving license number validation and format checking",
            status: "planned",
        },
        {
            name: "UK Passport Numbers",
            icon: "identification",
            description: "UK passport number validation and format verification",
            status: "planned",
        },
        {
            name: "VAT Numbers",
            icon: "currency-pound",
            description: "UK VAT number validation with checksum verification",
            status: "planned",
        },
        {
            name: "Company Registration Numbers",
            icon: "building-office",
            description: "UK company registration number validation",
            status: "planned",
        },
    ];

    // Icon component function
    function getIcon(iconName: string, className: string = "w-6 h-6") {
        const icons: Record<string, string> = {
            phone: `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
            </svg>`,
            "id-card": `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
            </svg>`,
            "map-pin": `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>`,
            "building-library": `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>`,
            envelope: `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>`,
            truck: `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM21 17a2 2 0 11-4 0 2 2 0 014 0zM21 13V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H7a2 2 0 01-2-2v-4m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>`,
            identification: `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
            </svg>`,
            "currency-pound": `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
            </svg>`,
            "building-office": `<svg class="${className}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>`,
        };
        return icons[iconName] || icons["id-card"];
    }

    // Helper function to safely get sample data
    function getSampleData(key: string): string[] {
        const data: Record<string, string[]> = {
            phone_numbers: sampleData.phone,
            national_insurance: sampleData.ni,
            postcodes: sampleData.postcode,
            sort_codes: sampleData.sortCode,
        };
        return data[key] || [];
    }

    let activeTab = "phone_numbers";
    let showFeedbackForm = false;
    let feedbackData = {
        dataType: "",
        suggestion: "",
        email: "",
    };

    function submitFeedback() {
        // In a real app, this would send to your backend
        alert("Thank you for your suggestion! We'll review it and consider adding it to our validation rules.");
        showFeedbackForm = false;
        feedbackData = { dataType: "", suggestion: "", email: "" };
    }
</script>

<svelte:head>
    <title>Validation Rules - File Data Validator</title>
    <meta name="description" content="Comprehensive guide to all validation rules for UK data formats including phone numbers, NI numbers, postcodes, and bank sort codes" />
</svelte:head>

<main class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Header -->
    <header class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Validation Rules & Standards</h1>
        <p class="text-xl text-gray-600 max-w-4xl mx-auto">
            Explore all the validation rules we currently support and see examples of how we process different data formats. Learn about automatic fixes and understand what makes data valid or
            invalid.
        </p>

        <!-- Navigation back to main validator -->
        <div class="mt-6">
            <a href="/validation/" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Data Validator
            </a>
        </div>
    </header>

    <!-- Tab Navigation -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto">
                {#each Object.entries(validationRules) as [key, rule]}
                    <button
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors {activeTab === key
                            ? 'border-blue-500 text-blue-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'}"
                        on:click={() => (activeTab = key)}
                    >
                        <span class="mr-2">{@html getIcon(rule.icon)}</span>
                        {rule.title}
                    </button>
                {/each}
            </nav>
        </div>
    </div>

    <!-- Active Tab Content -->
    {#each Object.entries(validationRules) as [key, rule]}
        {#if activeTab === key}
            <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
                <!-- Rule Header -->
                <div class="flex items-start mb-8">
                    <div class="text-4xl mr-4">{@html getIcon(rule.icon)}</div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{rule.title}</h2>
                        <p class="text-lg text-gray-600">{rule.description}</p>
                    </div>
                </div>

                <!-- Introduction -->
                <div class="bg-blue-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-blue-900 mb-4">How It Works</h3>
                    <p class="text-blue-800">{rule.intro}</p>
                </div>

                <!-- What We Check -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">What We Check</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {#each rule.whatWeCheck as check}
                            <div class="flex items-start">
                                <span class="text-green-500 mr-3 mt-1">✓</span>
                                <span class="text-gray-700">{check}</span>
                            </div>
                        {/each}
                    </div>
                </div>

                <!-- Automatic Fixes -->
                <div class="mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Automatic Fixes We Apply</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {#each rule.automaticFixes as fix}
                            <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                                <h4 class="text-lg font-semibold text-gray-800 mb-3">{fix.name}</h4>
                                <p class="text-gray-600 mb-4">{fix.description}</p>
                                <div class="space-y-2">
                                    {#each fix.examples as example}
                                        <div class="bg-gray-50 rounded p-3">
                                            <code class="text-sm font-mono text-gray-800">{example}</code>
                                        </div>
                                    {/each}
                                </div>
                            </div>
                        {/each}
                    </div>
                </div>

                <!-- Supported Formats -->
                <div class="bg-green-50 rounded-lg p-6 mb-8">
                    <h3 class="text-xl font-semibold text-green-900 mb-4">Supported Formats</h3>
                    <div class="space-y-4">
                        {#each rule.supportedFormats as format}
                            <div class="bg-white rounded-lg p-4 border border-green-200">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-green-800">{format.type}</h4>
                                    <code class="text-sm font-mono text-green-700 bg-green-100 px-2 py-1 rounded">{format.pattern}</code>
                                </div>
                                <p class="text-green-700 text-sm mb-3">{format.description}</p>
                                <div class="space-x-2">
                                    {#each format.examples as example}
                                        <code class="inline-block bg-white px-2 py-1 rounded text-sm font-mono text-green-800 border border-green-200">{example}</code>
                                    {/each}
                                </div>
                            </div>
                        {/each}
                    </div>
                </div>

                <!-- Discovered Formats (if any) -->
                {#if rule.discoveredFormats && rule.discoveredFormats.length > 0}
                    <div class="bg-yellow-50 rounded-lg p-6 mb-8">
                        <h3 class="text-xl font-semibold text-yellow-900 mb-4">New Formats We've Discovered</h3>
                        <p class="text-yellow-800 mb-4">As we encounter new formats, we add them here and implement fixes for them.</p>
                        <div class="space-y-4">
                            {#each rule.discoveredFormats as discovered}
                                <div class="bg-white rounded-lg p-4 border border-yellow-200">
                                    <div class="flex items-center justify-between mb-2">
                                        <code class="text-sm font-mono text-yellow-800 bg-yellow-100 px-2 py-1 rounded">{discovered.format}</code>
                                        <span class="text-xs text-yellow-600 bg-yellow-100 px-2 py-1 rounded">{discovered.dateAdded}</span>
                                    </div>
                                    <p class="text-yellow-700 text-sm mb-2">{discovered.description}</p>
                                    <span class="text-xs text-yellow-600 font-medium">{discovered.status}</span>
                                </div>
                            {/each}
                        </div>
                    </div>
                {/if}

                <!-- Output Format Options (for phone numbers only) -->
                {#if key === "phone_numbers"}
                    <div class="bg-blue-50 rounded-lg p-6 mb-8">
                        <h3 class="text-xl font-semibold text-blue-900 mb-4">Output Format Options</h3>
                        <p class="text-blue-700 mb-4">Choose how you want your phone numbers formatted in the results:</p>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white rounded-lg p-4">
                                <h4 class="font-medium text-blue-800 mb-2">International (+44)</h4>
                                <p class="text-blue-700 text-sm mb-2">Always includes +44 country code</p>
                                <code class="inline-block bg-blue-100 px-2 py-1 rounded text-sm font-mono text-blue-800">+44 7700 900123</code>
                            </div>
                            <div class="bg-white rounded-lg p-4">
                                <h4 class="font-medium text-blue-800 mb-2">UK (0)</h4>
                                <p class="text-blue-700 text-sm mb-2">UK domestic format starting with 0</p>
                                <code class="inline-block bg-blue-100 px-2 py-1 rounded text-sm font-mono text-blue-800">07700 900123</code>
                            </div>
                        </div>
                    </div>
                {/if}
            </div>
        {/if}
    {/each}

    <!-- Future Data Types -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">🚀 Coming Soon: More Data Types</h2>
        <p class="text-gray-600 mb-6">We're constantly expanding our validation capabilities. Here are some data types we're planning to add:</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {#each futureDataTypes as dataType}
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-6 border border-gray-200">
                    <div class="text-3xl mb-3">{@html getIcon(dataType.icon)}</div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{dataType.name}</h3>
                    <p class="text-gray-600 text-sm mb-3">{dataType.description}</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {dataType.status}
                    </span>
                </div>
            {/each}
        </div>
    </div>

    <!-- Feedback Section -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">💡 Suggest New Validation Rules</h2>
        <p class="text-gray-600 mb-6">Is there a data type you'd like us to validate? Let us know what you need and we'll consider adding it to our validation engine.</p>

        {#if !showFeedbackForm}
            <button on:click={() => (showFeedbackForm = true)} class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition-colors">
                Suggest New Validation Rule
            </button>
        {:else}
            <form on:submit|preventDefault={submitFeedback} class="space-y-4">
                <div>
                    <label for="dataType" class="block text-sm font-medium text-gray-700 mb-1">Data Type</label>
                    <input
                        bind:value={feedbackData.dataType}
                        type="text"
                        id="dataType"
                        placeholder="e.g., UK Driving License, VAT Number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    />
                </div>

                <div>
                    <label for="suggestion" class="block text-sm font-medium text-gray-700 mb-1">Description & Examples</label>
                    <textarea
                        bind:value={feedbackData.suggestion}
                        id="suggestion"
                        rows="4"
                        placeholder="Describe the data format, provide examples, and explain why validation would be useful..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required
                    ></textarea>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Your Email (optional)</label>
                    <input
                        bind:value={feedbackData.email}
                        type="email"
                        id="email"
                        placeholder="email@example.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                    />
                </div>

                <div class="flex space-x-3">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-700 transition-colors"> Submit Suggestion </button>
                    <button type="button" on:click={() => (showFeedbackForm = false)} class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        {/if}
    </div>
</main>

<!-- Footer -->
<footer class="bg-gray-50 border-t border-gray-200 mt-16">
    <div class="container mx-auto px-4 py-8 max-w-6xl">
        <div class="text-center">
            <p class="text-sm text-gray-600 mb-2">🔒 Your data is processed locally and never transmitted to our servers</p>
            <div class="space-x-4 text-sm">
                <a href="/validation/" class="text-blue-600 hover:text-blue-800 underline">Data Validator</a>
                <span class="text-gray-400">•</span>
                <a href="/validation/privacy" class="text-blue-600 hover:text-blue-800 underline">Privacy Policy</a>
                <span class="text-gray-400">•</span>
                <span class="text-gray-600">GDPR Compliant</span>
            </div>
        </div>
    </div>
</footer>
