/**
 * Solicita confirmación antes de enviar un formulario de eliminación.
 *
 * El formulario debe incluir el atributo `data-name` con el nombre del
 * elemento a eliminar, por ejemplo:
 *   <form ... onsubmit="return confirmDelete(this);" data-name="Juan">
 *
 * @param {HTMLFormElement} form
 * @returns {boolean}
 */
function confirmDelete(form) {

    var name = form.getAttribute('data-name');
    return confirm('¿Eliminar al usuario ' + name + '?');
}

/**
 * Confirmación para eliminar un docente (usa el atributo data-name del formulario).
 *
 * @param {HTMLFormElement} form
 * @returns {boolean}
 */
/**
 * Confirmación para eliminar una universidad (usa el atributo data-name del formulario).
 *
 * @param {HTMLFormElement} form
 * @returns {boolean}
 */
function confirmDeleteUniversidad(form) {

    var name = form.getAttribute('data-name');
    return confirm('¿Eliminar la universidad ' + name + '? Esta acción no se puede deshacer.');
}

function confirmDeleteDocente(form) {

    var name = form.getAttribute('data-name');
    return confirm('¿Eliminar al docente ' + name + '? Esta acción no se puede deshacer.');
}
