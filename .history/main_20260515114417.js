// SportSpace — shared JS utilities

document.querySelectorAll('.navbar-links a').forEach(link => {
  if (link.href === window.location.href) link.classList.add('active');
});

function toggleSlot(btn) {
  if (btn.classList.contains('penuh')) return;
  btn.classList.toggle('selected');
  updateBookingSummary();
}

function updateBookingSummary() {
  const slots = [...document.querySelectorAll('.slot-btn.selected')];
  const count = slots.length;
  const pricePerHour = parseInt(document.getElementById('price-per-hour')?.dataset.price || 80000);
  const total = count * pricePerHour;

  const elDurasi = document.getElementById('summary-durasi');
  const elTotal = document.getElementById('summary-total');
  const elWaktu = document.getElementById('summary-waktu');
  const elBtn = document.getElementById('btn-booking');

  if (elDurasi) elDurasi.textContent = count + ' jam';
  if (elTotal) elTotal.textContent = 'Rp' + total.toLocaleString('id-ID');
  if (elWaktu && slots.length > 0) {
    const start = slots[0].dataset.start;
    const end = slots[slots.length - 1].dataset.end;
    elWaktu.textContent = start + ' – ' + end;
  } else if (elWaktu) {
    elWaktu.textContent = '—';
  }
  if (elBtn) elBtn.disabled = count === 0;
}

function selectDay(btn) {
  document.querySelectorAll('.day-btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
}

function selectRole(role) {
  document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
  const el = document.getElementById('role-' + role);
  if (el) el.classList.add('selected');
  const note = document.getElementById('owner-note');
  if (note) note.style.display = role === 'owner' ? 'flex' : 'none';
}

function switchTab(name) {
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.toggle('active', b.dataset.tab === name));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.toggle('active', p.id === 'panel-' + name));
}

document.querySelectorAll('.filter-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
  });
});

document.querySelectorAll('.sidebar-item').forEach(item => {
  item.addEventListener('click', () => {
    document.querySelectorAll('.sidebar-item').forEach(i => i.classList.remove('active'));
    item.classList.add('active');
  });
});

function jalankanCari() {
    console.log("Fungsi jalankanCari berhasil dipicu!"); // Tes di console

    const input = document.getElementById('searchInput');
    if (!input) {
        console.error("Input dengan ID 'searchInput' tidak ditemukan!");
        return;
    }

    const keyword = input.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.field-card');
    const filterBtns = document.querySelectorAll('.filter-btn');

    cards.forEach(card => {
        const text = card.innerText.toLowerCase();
        if (text.includes(keyword)) {
            card.style.display = ""; 
        } else {
            card.style.display = "none";
        }
    });
 
    filterBtns.forEach(btn => {
        const btnText = btn.innerText.toLowerCase();
        if (keyword.includes(btnText) || (keyword === "" && btnText === "semua")) {
            filterBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
    });

    const target = document.getElementById('lapangan');
    if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
    } else {
        console.warn("Target id='lapangan' tidak ditemukan!");
    }
}
document.getElementById('searchInput')?.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        jalankanCari();
    }
});