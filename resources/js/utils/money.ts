/**
 * Utility functions for handling money values
 */

/**
 * Convert a decimal amount (e.g. 10.99) to cents as integer (1099)
 * This ensures proper handling of floating point precision issues
 */
export function toCents(amount: number): number {
    return Math.round(amount * 100);
}

/**
 * Convert cents as integer (e.g. 1099) back to decimal amount (10.99)
 */
export function fromCents(cents: number): number {
    return cents / 100;
}

/**
 * Format a decimal amount as a currency string with 2 decimal places
 * @param amount The amount to format
 * @param currency The currency code (default: USD)
 * @returns Formatted currency string
 */
export function formatCurrency(amount: number, currency = 'USD'): string {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(amount);
}

/**
 * Ensures a value is a valid currency value with at most 2 decimal places
 * @param value The value to normalize
 * @returns Normalized value with at most 2 decimal places
 */
export function normalizeCurrencyValue(value: number): number {
    return Math.round(value * 100) / 100;
}
