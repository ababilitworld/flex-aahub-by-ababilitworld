// Asset/App/Js/Exception/ExceptionHandlerFactory.js
import { Exception as ToastExceptionHandler } from '../Concrete/Toast/Exception.js';
import { InlineExceptionHandler } from './InlineExceptionHandler.js';

/**
 * Exception Handler Factory
 * Creates appropriate error handlers based on type
 */
export class Exception
{
    static TYPES = {
        TOAST: 'toast',
        INLINE: 'inline'
    };

    static create(type = 'toast', config = {}) 
    {
        switch (type) {
            case this.TYPES.TOAST:
            return new ToastExceptionHandler(config);
            
            case this.TYPES.INLINE:
            return new InlineExceptionHandler(config);
            
            default:
            console.warn(`Unknown error handler type: ${type}. Using toast as default.`);
            return new ToastExceptionHandler(config);
        }
    }

    static createFromEnvironment(config = {}) 
    {
        // Determine best error handler based on environment
        const isMobile = window.innerWidth < 768;
        const isTouchDevice = 'ontouchstart' in window;

        if (isMobile || isTouchDevice) {
            return this.create(this.TYPES.INLINE, {
            autoHide: true,
            duration: 4000,
            ...config
            });
        }

        return this.create(this.TYPES.TOAST, {
            autoHide: true,
            duration: 5000,
            ...config
        });
    }
}