<?php
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/Api.php';
require_once __DIR__ . '/../models/Model.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../includes/Auth.php';

class DataCleanerApi extends Api {
    public function handleRequest() {
        try {
            $startTime = microtime(true);

            // Validate request method
            $this->validateRequestMethod('POST');

            // Validate authentication
            $this->requireAuth();
            $this->validateApiKey();

            // Check subscription and limits
            $subscription = $this->checkSubscription();

            // Get and validate request data
            $data = $this->getRequestData();
            $this->validateRequiredFields($data, ['data', 'fields']);

            // Validate data size
            $dataSize = strlen(json_encode($data));
            $rateLimiter = RateLimiter::getInstance();
            $rateLimiter->checkFileSize($dataSize, $this->user['id']);

            // Process the data
            $result = $this->processData($data['data'], $data['fields']);

            // Log successful API usage
            $processingTime = microtime(true) - $startTime;
            $rateLimiter = RateLimiter::getInstance();
            $rateLimiter->logRequest($this->user['id'], 'clean', $dataSize, $processingTime, 'success');

            // Send response
            $this->sendResponse($result);
        } catch (Exception $e) {
            // Log error
            $rateLimiter = RateLimiter::getInstance();
            $rateLimiter->logRequest($this->user['id'], 'clean', $dataSize ?? null, null, 'error', $e->getMessage());

            // Send error response
            $this->sendError($e->getMessage());
        }
    }

    private function processData($data, $fields) {
        $fileProcessor = new FileProcessor($data['phone_format'] ?? 'international');
        $results = [];

        foreach ($data as $row) {
            $rowResults = [];
            foreach ($fields as $field) {
                if (isset($row[$field])) {
                    $validator = getValidator($this->detectFieldType($field));
                    if ($validator) {
                        $validation = $validator->validate($row[$field]);
                        $rowResults[$field] = [
                            'original' => $row[$field],
                            'cleaned' => $validation->fixed,
                            'valid' => $validation->isValid,
                            'error' => $validation->error
                        ];
                    }
                }
            }
            $results[] = $rowResults;
        }

        return [
            'results' => $results,
            'summary' => $this->generateSummary($results)
        ];
    }

    private function detectFieldType($fieldName) {
        $fieldName = strtolower($fieldName);

        if (strpos($fieldName, 'phone') !== false || strpos($fieldName, 'mobile') !== false || strpos($fieldName, 'tel') !== false) {
            return 'phone_number';
        }

        if (strpos($fieldName, 'ni') !== false || strpos($fieldName, 'insurance') !== false) {
            return 'ni_number';
        }

        if (strpos($fieldName, 'postcode') !== false || strpos($fieldName, 'post_code') !== false) {
            return 'postcode';
        }

        if (strpos($fieldName, 'sort') !== false || strpos($fieldName, 'bank') !== false) {
            return 'sort_code';
        }

        return null;
    }

    private function generateSummary($results) {
        $totalFields = 0;
        $validFields = 0;
        $cleanedFields = 0;
        $errors = 0;

        foreach ($results as $row) {
            foreach ($row as $field) {
                $totalFields++;
                if ($field['valid']) {
                    $validFields++;
                    if ($field['original'] !== $field['cleaned']) {
                        $cleanedFields++;
                    }
                } else {
                    $errors++;
                }
            }
        }

        return [
            'total_fields' => $totalFields,
            'valid_fields' => $validFields,
            'cleaned_fields' => $cleanedFields,
            'errors' => $errors,
            'success_rate' => $totalFields > 0 ? ($validFields / $totalFields) * 100 : 0
        ];
    }
}

// Handle the request
$api = new DataCleanerApi();
$api->handleRequest();
