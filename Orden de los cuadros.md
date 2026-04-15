Reformulemos.
Al principio, los cuadros tendran una posicion al azar, respecto a su posicion ideal y los cuadros no estaran seleccionados.

Hay dos formas de reubicar la posicion de un cuadro, dando clic o arrastrandolo.
1. Dando clic. 
a) Clic sobre un cuadro que no este seleccionado: El cuadro se seleccionara y se colocara en la posicion que le sigue al ultimo cuadro seleccionado. Si no hay ningun cuadro seleccionado, se colocara en la posicion 1.

Si es el ultimo (18) ahi se quedara. Si es el primero (1) se quedara en la posicion 1.

2. Arrastrandolo.
a) Se arrastrara con el mouse o con el dedo en tablet o celular. 
    i) si el cuadro arrastrado ya estaba seleccionado y se posiciona entre otros cuadros seleccionados o despues del ultimo seleccionado, su badge tomara el valor de la posicion en que se ubico y los cuadros seleccionados que estan por delante se renumerara de forma secuencial , manteniendo la secuencia.
    ii) si el cuadro arrastrado ya estaba seleccionado y se intenta poner despues del ultimo seleccionado, el cuadro se quedara en la posicion que le sigue al ultimo seleccionado, y los cuadros seleccionados que estan por detras se reubicaran de forma secuencial manteniendo la secuencia, en el badge y en la posicion.
    iii) si el cuadro arrastrado no estaba seleccionado y se intenta soltar por atras de un cuadro seleccionado, no se permitira este movimiento.
    iv) si el cuadro arrastrado no esta seleccionado y se posicion despues de otro no seleccionado ese movimiento si se permite.

    Se ha ocultado la sección "Las 18 Fórmulas Axiológicas" en la página de documentación para usuarios que no son administradores (usuarios tipo user y visitantes no autenticados).

Cambios realizados:
Vista de Documentación: Se añadió una validación de seguridad en resources/views/livewire/documentation.blade.php para envolver la sección de fórmulas. Ahora solo los usuarios con el rol admin pueden visualizar esta información técnica detallada de la metodología Hartman.
Lógica de Acceso: Se utilizó el método isAdmin() del modelo User para asegurar que tanto los invitados como los usuarios regulares tengan restringido el acceso a esta sección específica.
Los demás apartados de la documentación (Fundamentos, Variables Axiológicas, etc.) permanecen visibles para todos los usuarios, permitiéndoles entender la teoría sin exponer las fórmulas exactas del algoritmo.