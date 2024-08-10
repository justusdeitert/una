import Draggable from 'draggable';

// Initialize the draggable element
const element = document.getElementById('draggable');

if (element) {
    const drag = new Draggable(element);

    // Set the initial position
    drag.set(50, 120);
}

// Add event listener to handle click and touchstart on the icon inside the draggable element
const iconElement = document.querySelector('#draggable i');

if (iconElement) {
    iconElement.addEventListener('click', () => {
        element?.classList.add('hide');
    });

    iconElement.addEventListener('touchstart', () => {
        element?.classList.add('hide');
    });
}
