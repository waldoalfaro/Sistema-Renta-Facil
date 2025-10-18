const manualData = {
    'cliente': {
        title: 'Manual de Cliente',
        file: 'manuales/manual-cliente.pdf'
    },
    'administrador': {
        title: 'Manual de Administrador',
        file: 'manuales/manual-administrador.pdf'
    },
    'empleado': {
        title: 'Manual de Empleado',
        file: 'manuales/manual-empleado.pdf'
    }
};

function openManual(type) {
    const modal = document.getElementById('pdfModal');
    const modalTitle = document.getElementById('modalTitle');
    const pdfViewer = document.getElementById('pdfViewer');
    const downloadBtn = document.getElementById('downloadBtn');
    
    const manual = manualData[type];
    
    modalTitle.textContent = manual.title;
    pdfViewer.src = manual.file;
    downloadBtn.href = manual.file;
    
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('pdfModal');
    const pdfViewer = document.getElementById('pdfViewer');
    
    modal.style.display = 'none';
    pdfViewer.src = '';
    document.body.style.overflow = 'auto';
}

window.onclick = function(event) {
    const modal = document.getElementById('pdfModal');
    if (event.target === modal) {
        closeModal();
    }
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});

document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});
