(function () {
  const body = document.body;
  const menuButton = document.querySelector('[data-menu-toggle]');

  if (menuButton) {
    menuButton.addEventListener('click', () => {
      const isOpen = body.classList.toggle('tad-menu-open');
      menuButton.setAttribute('aria-expanded', String(isOpen));
    });
  }

  document.querySelectorAll('[data-slider], [data-carousel]').forEach((slider) => {
    const track = slider.querySelector('.tad-slider-track, .tad-carousel-track');
    const items = track ? Array.from(track.children) : [];
    let index = 0;

    if (!track || items.length < 2) return;

    window.setInterval(() => {
      index = (index + 1) % items.length;
      const width = items[0].getBoundingClientRect().width;
      track.style.transform = `translateX(-${index * width}px)`;
    }, slider.hasAttribute('data-carousel') ? 3200 : 4200);
  });

  document.querySelectorAll('[data-countdown]').forEach((node) => {
    const hours = Number(node.dataset.hours || 24);
    const endTime = Date.now() + hours * 60 * 60 * 1000;

    const render = () => {
      const remaining = Math.max(0, endTime - Date.now());
      const totalSeconds = Math.floor(remaining / 1000);
      const days = Math.floor(totalSeconds / 86400);
      const hrs = Math.floor((totalSeconds % 86400) / 3600);
      const mins = Math.floor((totalSeconds % 3600) / 60);
      const secs = totalSeconds % 60;
      const boxes = [
        ['Días', days],
        ['Horas', hrs],
        ['Min', mins],
        ['Seg', secs],
      ];

      node.innerHTML = boxes
        .map(([label, value]) => `<span class="tad-timebox"><strong>${String(value).padStart(2, '0')}</strong><span>${label}</span></span>`)
        .join('');
    };

    render();
    window.setInterval(render, 1000);
  });
})();
