// Asset/App/Js/Exception/Concrete/Toast/Exception.js
import { Exception as BaseException } from '../../Base/Exception.js';

/**
 * Toast-style Error Handler
 * Displays non-intrusive toast notifications
 */
export class Exception extends BaseException 
{
    constructor(config = {}) 
    {
        super({
            position: 'fixed',
            container: 'body',
            autoHide: true,
            duration: 4000,
            type: 'error',
            ...config
        });
    }

    createErrorElement(message, options) 
    {
        const errorElement = document.createElement('div');
        errorElement.className = `portfolio-error-toast portfolio-error-${options.type}`;
        errorElement.innerHTML = `
            <div class="error-toast-content">
            <span class="error-icon">${this.getIcon(options.type)}</span>
            <span class="error-text">${this.escapeHtml(message)}</span>
            <button class="error-close" aria-label="Close error message">&times;</button>
            </div>
        `;
        return errorElement;
    }

    displayError(errorElement, options) 
    {
        // Ensure styles are injected
        this.injectStyles();

        // Add to appropriate container
        const container = options.container === 'body' ? 
            document.body : 
            document.querySelector(options.container);

        if (container) {
            if (options.position === 'prepend') {
            container.insertBefore(errorElement, container.firstChild);
            } else {
            container.appendChild(errorElement);
            }
        } else {
            document.body.appendChild(errorElement);
        }

        // Animate in
        this.animateIn(errorElement);
    }

    setupInteractions(errorElement, options) 
    {
        const closeBtn = errorElement.querySelector('.error-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
            this.hide(errorElement);
            });
        }

        // Optional: Click outside to close
        if (options.closeOnClick) {
            errorElement.addEventListener('click', (e) => {
            if (e.target === errorElement) {
                this.hide(errorElement);
            }
            });
        }
    }

    getIcon(type) 
    {
        const icons = {
            error: '⚠',
            warning: '⚠',
            info: 'ℹ',
            success: '✓'
        };
        return icons[type] || icons.error;
    }

    injectStyles() 
    {
        if (document.getElementById('portfolio-error-styles')) return;

        const styles = `
            .portfolio-error-toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #fff;
            border-left: 4px solid #e74c3c;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            padding: 12px 16px;
            min-width: 300px;
            max-width: 500px;
            z-index: 10000;
            transform: translateX(100%);
            transition: transform 0.3s ease, opacity 0.3s ease;
            }
            
            .portfolio-error-toast.show {
            transform: translateX(0);
            }
            
            .portfolio-error-warning { border-left-color: #f39c12; }
            .portfolio-error-info { border-left-color: #3498db; }
            .portfolio-error-success { border-left-color: #2ecc71; }
            
            .error-toast-content {
            display: flex;
            align-items: center;
            gap: 12px;
            }
            
            .error-icon { font-size: 16px; }
            .error-text { flex: 1; font-size: 14px; color: #333; }
            .error-close { 
            background: none; 
            border: none; 
            font-size: 18px; 
            cursor: pointer; 
            color: #999;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            }
            .error-close:hover { color: #333; }
        `;

        const styleElement = document.createElement('style');
        styleElement.id = 'portfolio-error-styles';
        styleElement.textContent = styles;
        document.head.appendChild(styleElement);
    }

    // Override animateIn for toast-specific animation
    animateIn(element, callback) 
    {
        element.style.transform = 'translateX(100%)';
        element.style.opacity = '0';
        element.style.display = 'block';

        setTimeout(() => {
            element.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
            element.style.transform = 'translateX(0)';
            element.style.opacity = '1';
            
            if (callback) {
            setTimeout(callback, 300);
            }
        }, 10);
    }

    animateOut(element, callback) 
    {
        element.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
        element.style.transform = 'translateX(100%)';
        element.style.opacity = '0';

        setTimeout(() => {
            if (callback) {
            callback();
            }
        }, 300);
    }
}