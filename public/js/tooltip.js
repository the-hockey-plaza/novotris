/**
 * Tooltip System
 * 
 * Desktop: Hover + Focus aktiviert Tooltip
 * Mobile: Info-Icon neben Label, Tap zeigt Tooltip
 * 
 * Usage HTML:
 *   <div data-tooltip="Tooltip-Text">Element</div>
 *   oder für Labels mit Icon:
 *   <label>
 *     Label-Text
 *     <span class="tooltip-icon" data-tooltip="Tooltip-Text">ℹ</span>
 *   </label>
 */

var glTooltipSystem = {
  tooltips: new Map(),
  activeTooltip: null,
  isMobile: false,

  init: function () {
    this.isMobile = typeof glIsMobile !== 'undefined' ? glIsMobile : this.detectMobile();

    // Find all elements with data-tooltip attribute
    const elements = document.querySelectorAll('[data-tooltip]');
    elements.forEach((el) => {
      this.attachTooltip(el);
    });

    // Event listener for closing tooltips on escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        this.hideTooltip();
      }
    });

    // Close tooltip on window scroll
    window.addEventListener('scroll', () => {
      if (this.activeTooltip) {
        this.hideTooltip();
      }
    }, { passive: true });
  },

  detectMobile: function () {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
  },

  attachTooltip: function (element) {
    if (this.isMobile) {
      this.attachMobileTooltip(element);
    } else {
      this.attachDesktopTooltip(element);
    }
  },

  attachDesktopTooltip: function (element) {
    // Hover and focus show tooltip
    element.addEventListener('mouseenter', (e) => this.showTooltip(e.target));
    element.addEventListener('focus', (e) => this.showTooltip(e.target), true);
    element.addEventListener('mouseleave', () => this.hideTooltip());
    element.addEventListener('blur', () => this.hideTooltip(), true);
  },

  attachMobileTooltip: function (element) {
    const tooltipIcon = element.querySelector('.tooltip-icon');

    if (tooltipIcon) {
      // Icon-based tooltip for labels
      tooltipIcon.style.cursor = 'pointer';
      tooltipIcon.addEventListener('touchstart', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.showTooltip(tooltipIcon);
      });
      tooltipIcon.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        this.showTooltip(tooltipIcon);
      });
    } else {
      // Direct tap on element
      element.addEventListener('touchstart', (e) => {
        if (this.activeTooltip === element) {
          this.hideTooltip();
        } else {
          this.showTooltip(element);
        }
      });
    }
  },

  showTooltip: function (element) {
    const tooltipText = element.getAttribute('data-tooltip');
    if (!tooltipText) return;

    // Hide previous tooltip
    if (this.activeTooltip) {
      this.hideTooltip();
    }

    // Create or get tooltip element
    let tooltip = document.getElementById('global-tooltip');
    if (!tooltip) {
      tooltip = document.createElement('div');
      tooltip.id = 'global-tooltip';
      tooltip.className = 'tooltip';
      document.body.appendChild(tooltip);
    }

    tooltip.textContent = tooltipText;
    tooltip.style.display = 'block';
    this.activeTooltip = element;

    // Position tooltip
    this.positionTooltip(tooltip, element);

    // Add visible class for animation
    setTimeout(() => {
      tooltip.classList.add('tooltip-visible');
    }, 0);
  },

  positionTooltip: function (tooltip, element) {
    const rect = element.getBoundingClientRect();
    const tooltipWidth = 240;
    const padding = 8;
    const gap = 8;

    let left = rect.left + rect.width / 2 - tooltipWidth / 2;
    let top = rect.top - gap;

    // Keep tooltip inside viewport
    if (left < padding) {
      left = padding;
    }
    if (left + tooltipWidth > window.innerWidth - padding) {
      left = window.innerWidth - tooltipWidth - padding;
    }

    // Try positioning above first
    if (top < 50) {
      // Position below instead
      top = rect.bottom + gap;
    }

    tooltip.style.left = left + 'px';
    tooltip.style.top = top + 'px';
    tooltip.style.maxWidth = tooltipWidth + 'px';
  },

  hideTooltip: function () {
    const tooltip = document.getElementById('global-tooltip');
    if (tooltip) {
      tooltip.classList.remove('tooltip-visible');
      setTimeout(() => {
        tooltip.style.display = 'none';
      }, 150);
    }
    this.activeTooltip = null;
  }
};

// Initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', function () {
    glTooltipSystem.init();
  });
} else {
  glTooltipSystem.init();
}
