import '@testing-library/jest-dom';
import { vi } from 'vitest';

// Mock fetch globally for tests
global.fetch = vi.fn();

// Mock File and FileReader for file upload testing
global.File = class MockFile {
    name: string;
    size: number;
    type: string;
    constructor(parts: string[], filename: string, options?: { type?: string }) {
        this.name = filename;
        this.size = parts.join('').length;
        this.type = options?.type || 'text/plain';
    }
} as any;

global.FileReader = class MockFileReader {
    readAsText(blob: Blob) {
        setTimeout(() => {
            if (this.onload) {
                this.onload({ target: { result: 'mock file content' } } as any);
            }
        }, 0);
    }
    onload: ((this: FileReader, ev: ProgressEvent<FileReader>) => any) | null = null;
} as any;
