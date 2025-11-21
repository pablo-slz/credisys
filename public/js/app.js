// public/js/app.js
document.addEventListener('DOMContentLoaded', () => {
  initFilterByEstado('#filtro-estado', '.credits-table tbody tr');
  initSearch('#buscar-creditos', '.credits-table tbody tr');
  initConfirmActions('.confirm-approve', '¿Aprobar este crédito?');
  initConfirmActions('.confirm-reject', '¿Rechazar este crédito?');
  initSolicitudValidation('#form-solicitud-credito');
});

/* Filtra filas de tabla por estado (client-side) */
function initFilterByEstado(selectSelector, rowSelector) {
  const select = document.querySelector(selectSelector);
  if (!select) return;
  select.addEventListener('change', () => {
    const val = select.value.toLowerCase();
    document.querySelectorAll(rowSelector).forEach(row => {
      const estadoCell = row.querySelector('td[data-estado]') || row.cells[row.cells.length - 1];
      const estadoText = estadoCell ? (estadoCell.dataset.estado || estadoCell.textContent).toLowerCase() : '';
      row.style.display = (val === 'todos' || estadoText.includes(val)) ? '' : 'none';
    });
  });

  // trigger inicial para que el select actual aplique si viene preseleccionado
  select.dispatchEvent(new Event('change'));
}

/* Buscador simple que filtra por todo el texto de la fila */
function initSearch(inputSelector, rowSelector) {
  const input = document.querySelector(inputSelector);
  if (!input) return;
  input.addEventListener('input', () => {
    const q = input.value.trim().toLowerCase();
    document.querySelectorAll(rowSelector).forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
  });
}

/* Confirmación antes de seguir el link (usa href del enlace) */
function initConfirmActions(selector, message) {
  document.querySelectorAll(selector).forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      const href = el.getAttribute('href');
      if (!href) return;
      if (confirm(message)) {
        // redirige
        window.location.href = href;
      }
    });
  });
}

/* Validación simple en el formulario de solicitud de crédito */
function initSolicitudValidation(formSelector) {
  const form = document.querySelector(formSelector);
  if (!form) return;
  form.addEventListener('submit', (e) => {
    const monto = parseFloat(form.querySelector('[name="monto"]').value) || 0;
    const plazo = parseInt(form.querySelector('[name="plazo"]').value) || 0;

    if (monto <= 0) {
      e.preventDefault();
      alert('Ingresa un monto válido mayor que 0.');
      return;
    }
    if (plazo <= 0) {
      e.preventDefault();
      alert('Ingresa un plazo (meses) válido mayor que 0.');
      return;
    }

    // Si quieres, deshabilitar botón y mostrar "Enviando..." visual
    const btn = form.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Enviando...';
    }
  });
}

/* Función de ayuda para mostrar un toast simple (opcional)
   Para usar: showToast('Mensaje', 3000);
*/
function showToast(msg, time = 2500) {
  let container = document.getElementById('toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    Object.assign(container.style, {
      position: 'fixed', right: '20px', bottom: '20px',
      zIndex: 9999, fontFamily: 'Arial, sans-serif'
    });
    document.body.appendChild(container);
  }
  const t = document.createElement('div');
  t.textContent = msg;
  Object.assign(t.style, {
    margin: '6px 0', padding: '10px 14px', background:'#222', color:'#fff',
    borderRadius: '6px', boxShadow: '0 2px 6px rgba(0,0,0,0.3)'
  });
  container.appendChild(t);
  setTimeout(() => t.remove(), time);
}
