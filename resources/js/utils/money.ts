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
 * Format a decimal amount as a currency string
 * @param amount The amount to format
 * @param currency The currency code (default: USD)
 * @param valueInCents Whether the amount is in cents (default: false)
 * @returns Formatted currency string
 */
export function formatCurrency(amount: number, currency = 'USD', valueInCents = false): string {
    const valueToFormat = valueInCents ? fromCents(amount) : amount;
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: currency,
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    }).format(valueToFormat);
}

/**
 * Ensures a value is a valid currency value with at most 2 decimal places
 * @param value The value to normalize
 * @returns Normalized value with at most 2 decimal places
 */
export function normalizeCurrencyValue(value: number): number {
    return Math.round(value * 100) / 100;
}

/**
 * Format a price specifically for product displays
 * @param price The price in cents
 * @param currency The currency code (default: USD)
 * @returns Formatted price string for product displays
 */
export function formatProductPrice(price: number, currency = 'USD'): string {
    return formatCurrency(price, currency, true);
}

/**
 * Parses a price value from various formats
 * @param price The price value which can be a string or number
 * @param isCents Whether the input is already in cents
 * @returns Normalized price in dollars as a number
 */
export function parsePrice(price: string | number, isCents = true): number {
    let numericValue: number;

    if (typeof price === 'string') {
        const cleanedString = price.replace(/[^\d.]/g, '');
        numericValue = parseFloat(cleanedString);
    } else {
        numericValue = price;
    }

    return isCents ? fromCents(numericValue) : numericValue;
}
