document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('employeeModal');
    
    window.addEventListener('openModal', () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    });

    window.addEventListener('closeModal', () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    });

    // Close the modal when clicking outside the modal content
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            Livewire.emit('closeAbsentEmployeeDetails'); // Trigger Livewire to close modal
        }
    });
});
