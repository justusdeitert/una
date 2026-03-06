import Draggable from 'draggable';

const element = document.getElementById('draggable');

if (element) {
    const drag = new Draggable(element);
    drag.set(50, 120);
}

const iconElement = document.querySelector('#draggable i');

if (iconElement) {
    iconElement.addEventListener('click', () => {
        element?.classList.add('hide');
    });

    iconElement.addEventListener('touchstart', () => {
        element?.classList.add('hide');
    });
}
