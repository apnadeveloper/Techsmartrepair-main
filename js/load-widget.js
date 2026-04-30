// load-widget.js
fetch('whatsapp-widget.html')
  .then(response => response.text())
  .then(data => {
    document.body.insertAdjacentHTML('beforeend', data);
  });
