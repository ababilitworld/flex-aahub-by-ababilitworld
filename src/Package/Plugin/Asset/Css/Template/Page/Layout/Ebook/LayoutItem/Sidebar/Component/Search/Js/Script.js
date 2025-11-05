document.getElementById('searchInput').addEventListener('input', function () {
    const searchTerm = this.value.toLowerCase();
    const buttons = document.querySelectorAll('.accordion-button');
    const contents = document.querySelectorAll('.accordion-content');
  
    buttons.forEach((btn) => {
      const text = btn.textContent.toLowerCase();
      const match = text.includes(searchTerm);
  
      if (match || searchTerm === '') {
        btn.style.display = 'block';
      } else {
        btn.style.display = 'none';
      }
    });
  
    // Auto-expand parent buttons if their children are matched
    contents.forEach((content) => {
      const children = content.querySelectorAll('.accordion-button');
      let hasMatch = false;
  
      children.forEach((child) => {
        if (child.style.display === 'block') {
          hasMatch = true;
        }
      });
  
      if (hasMatch) {
        content.style.display = 'block';
        const parentBtn = content.previousElementSibling;
        if (parentBtn) parentBtn.classList.add('open');
      } else if (searchTerm !== '') {
        content.style.display = 'none';
      }
    });
  });
  