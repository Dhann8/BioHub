window.openTab = function(evt, tabName) {
  document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
  
  const targetTab = document.getElementById(tabName);
  if (targetTab) {
    targetTab.classList.add('active');
  }
  if (evt && evt.currentTarget) {
    evt.currentTarget.classList.add('active');
  }
};

window.switchImage = function(thumbEl, src, alt) {
  const mainImg = document.getElementById('main-img');
  if (mainImg) {
    mainImg.style.opacity = '0';
    setTimeout(() => {
      mainImg.src = src;
      if (alt) mainImg.alt = alt;
      mainImg.style.opacity = '1';
    }, 150);
  }
  document.querySelectorAll('.thumb').forEach(t => t.classList.remove('thumb-active'));
  if (thumbEl) {
    thumbEl.classList.add('thumb-active');
  }
};


