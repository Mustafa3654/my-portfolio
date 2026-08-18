let deleteId = null;

function confirmDelete(e, id) {
  e.preventDefault();
  deleteId = id;
  const popup = document.getElementById('deleteConfirm');
  if (popup) {
    popup.classList.add('active');
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const yesBtn = document.getElementById('confirmYes');
  const noBtn = document.getElementById('confirmNo');

  if (yesBtn) {
    yesBtn.addEventListener('click', () => {
      if (deleteId !== null) {
        window.location.href = 'projects.php?delete=' + deleteId;
      }
    });
  }

  if (noBtn) {
    noBtn.addEventListener('click', () => {
      const popup = document.getElementById('deleteConfirm');
      if (popup) {
        popup.classList.remove('active');
        deleteId = null;
      }
    });
  }
});