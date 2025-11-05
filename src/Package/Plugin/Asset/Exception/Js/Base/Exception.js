// Asset/Exception/Js/Base/Exception.js
import { Exception as ExceptionContract } from '../Contract/Exception.js';

/**
 * Abstract Error Handler
 * Provides common functionality for concrete error handlers
 */
export class Exception extends ExceptionContract 
{
    constructor(config = {}) 
    {
        super();
        this.defaultConfig = {
            autoHide: true,
            duration: 5000,
            position: 'prepend',
            container: '.ababilithub',
            animationDuration: 300,
            ...config
        };
        this.config = { ...this.defaultConfig };
        this.activeErrors = new Set();
    }

    // Template Method Pattern - defines the algorithm skeleton
    show(message, options = {}) 
    {
        const mergedOptions = { ...this.config, ...options };

        // Validate input
        if (!this.validateMessage(message)) {
            console.warn('Invalid error message provided');
            return null;
        }

        // Create error element
        const errorElement = this.createErrorElement(message, mergedOptions);

        // Display error
        this.displayError(errorElement, mergedOptions);

        // Set up auto-hide if enabled
        if (mergedOptions.autoHide) {
            this.setupAutoHide(errorElement, mergedOptions);
        }

        // Set up interactions
        this.setupInteractions(errorElement, mergedOptions);

        // Track active error
        this.activeErrors.add(errorElement);

        return errorElement;
    }

    // Hook methods for subclasses to override
    createErrorElement(message, options) 
    {
        throw new Error('createErrorElement() must be implemented');
    }

    displayError(errorElement, options) 
    {
        throw new Error('displayError() must be implemented');
    }

    // Common functionality
    hide(errorElement) 
    {
        if (!errorElement) return;

        this.animateOut(errorElement, () => {
            if (errorElement.parentNode) {
            errorElement.remove();
            }
            this.activeErrors.delete(errorElement);
        });
    }

    clearAll() 
    {
        this.activeErrors.forEach(errorElement => {
            this.hide(errorElement);
        });
        this.activeErrors.clear();
    }

    setConfig(config) 
    {
        this.config = { ...this.config, ...config };
        return this;
    }

    resetConfig() 
    {
        this.config = { ...this.defaultConfig };
        return this;
    }

    // Protected methods for internal use
    validateMessage(message) 
    {
        return typeof message === 'string' && message.trim().length > 0;
    }

    escapeHtml(unsafe) 
    {
        if (typeof unsafe !== 'string') return unsafe;
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    animateIn(element, callback) 
    {
        element.style.opacity = '0';
        element.style.display = 'block';

        setTimeout(() => {
            element.style.transition = `opacity ${this.config.animationDuration}ms ease`;
            element.style.opacity = '1';
            
            if (callback) {
            setTimeout(callback, this.config.animationDuration);
            }
        }, 10);
    }

    animateOut(element, callback) 
    {
        element.style.transition = `opacity ${this.config.animationDuration}ms ease`;
        element.style.opacity = '0';

        setTimeout(() => {
            if (callback) {
            callback();
            }
        }, this.config.animationDuration);
    }

    setupAutoHide(errorElement, options) 
    {
        const timeoutId = setTimeout(() => {
            this.hide(errorElement);
        }, options.duration);

        // Store timeout ID for potential cancellation
        errorElement.dataset.autoHideTimeout = timeoutId;
    }

    setupInteractions(errorElement, options) 
    {
        // To be implemented by concrete classes
    }
}