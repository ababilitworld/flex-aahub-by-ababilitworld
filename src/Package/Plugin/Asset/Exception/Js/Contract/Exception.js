// Asset/Exception/Js/Contract/Exception.js
/**
 * Error Handler Interface
 * Defines the contract for all error handlers
 */
export class Exception 
{
    show(message, options = {}) 
    {
        throw new Error('show() method must be implemented');
    }

    hide(errorElement) 
    {
        throw new Error('hide() method must be implemented');
    }

    clearAll() 
    {
        throw new Error('clearAll() method must be implemented');
    }

    setConfig(config) 
    {
        throw new Error('setConfig() method must be implemented');
    }
}