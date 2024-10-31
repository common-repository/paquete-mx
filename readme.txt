=== Paquete.MX ===
Plugin Name: Paquete.MX
Contributors: gerardosteven
Donate link: #
Tags: paquetería, mensajería, envíos, woocommerce
Requires at least: 4.9
Tested up to: 5.4
Stable tag: 4.2.2
Requires PHP: 5.6.36
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Paquete.MX es un plugin que permite integrar los servicios de envío de Paquete.MX en tu tienda online con Woocommerce. El plugin automatiza el proceso de envío y recolección generándolos cada vez que un cliente realiza una compra en una tienda a través de Woocommerce.

== Description ==
Paquete.MX te permite integrar servicios de envío automáticos en los carritos de compra de tus clientes que compren en tu tienda realizada con Woocommerce. Para poder usar nuestros servicios, se requiere tener una cuenta de tipo empresarial en nuestros entornos de desarrollo y producción y el respectivo token de acceso de cada uno. El plugin te permite variar opciones de configuración como son: selección de paqueterías, comportamiento del cálculo de envío, etc.


== Installation ==

1. Copia los archivos del plugin al directorio `/wp-content/plugins/paquetemx`, o através de la sec´ción de Plugins de Wordpress.
2. Activa el plugin desde la sección de plugins de Wordpress.
3. En el dashboard de amdinistrador, ve a la sección Paquete.MX para configurar el plugin.
4. Varía las opciones de configuraciones de acuerdo a tu tienda y escoge si vas a operar en el entorno de desarrollo o de producción
5. Por cada entorno vas a requerir un token de acceso obtenido desde tu cuenta en Paquete.MX


== Frequently Asked Questions ==

= ¿Qué hago cuando un cliente hace una orden? =

Una vez que un cliente realice una compra en tu tienda, se generará automáticamente el envío y se solicitará la recolección al domicilio configurado en las opciones del Plugin. La etiqueta del envío y la factura se enviarán al email configurado. Cuando la paquetería pase a recolectar los paquetes del producto comprado, se deberán entregar embalados y con la etiqueta de envío pegada en la caja.

= ¿Cómo hago el embalaje de un paquete? =
Si el producto viene suelto sin caja, deberá meterse en una caja que contenga cacahuate para embalaje de tal forma que no haya movimiento dentro de la caja. La caja deberá estar emplayada y debe ser de las medidas especificadas en la configuración del producto en Woocommerce. Si la caja tiene medidas más grandes que las especificadas, es probable que se genere un costo adicional por sobrepeso.

= ¿En qué momento pasarán a recoger mis paquetes? =
El servicio de recolección es en un horario abierto. Si la recolección fue solicitada antes de las 14:00 hrs, el recolector de la paquetería deberá pasar al domicilio del remitente de 14:00hrs a 18:00 hrs. En el caso de que la recolección sea solicitada después de tal hora, el recolector pasará al día siguiente entre 09:00hrs y 18:00hrs.

= ¿Qué pasa si quiero que mi envío salga el día de hoy cuando ya son más de las 14:00hrs? =
Puede ir a entregar el paquete directamente en cualquier centro de servicio de la paquetería encargada del envío. Si es este caso deberá notificar a cualquiera de los teléfonos de atención de Paquete.MX (55) 7258-1176 y (55) 7258-3615 indicándonos que desea cancelar la recolección porque se hará la entrega del paquete en centro de servicio.

= ¿Qué pasa si no recibo la etiqueta de envío ni la factura? =
El plugin está desarrollado para tolerar errores. Si en algún momento del proceso, por alguna razón la realización del envío falla, el proceso de compra no se verá afectado y continuará con normalidad, y Paquete.MX será alertado de tal forma que el envío será realizado por nosotros de forma manual inmediatamente después de recibir la alerta. Lo mismo ocurre cuando la recolección no es realizada de forma exitosa.

= ¿Qué pasa si aparece SIN COBERTURA al calcular un envío? =
Cuando no se están tomando en cuenta todas las paqueterías en el cálculo del envío hay una ligera probabilidad de que en algún momento no haya cobertura de envío por alguna paquetería, cuando el destino sea una zona muy remota. En este caso hay dos opciones: se omite el pago en el proceso de checkout, o se hace el pago del carrito únicamente. Esto se configura en los ajustes del Plugin. En ambos casos deberá comunicarse a cualquiera de nuestros teléfonos de atención de Paquete.MX (55) 7258-1176 y (55) 7258-3615 para buscar una alternativa.

== Screenshots ==

1. Pantalla de configuración.
2. Admin de cuenta empresarial en Paquete.MX.
3. Checkout.

== Changelog ==

= 4.2.2 =
Se valida la instalación de la extensión mbstring.
= 4.2.1 =
Se valida la instalación de la extensión cURL. El enlace de la documentación también se agrega en la página de configuración del plugin.
= 4.2.0 =
Implementación de retención de envío, para cuando se desee generar la etiqueta de envío después de que una compra se haya realizada.
= 4.1.0 =
Tasa de incremento en costo de envío implementada
= 4.0.1 =
Bug corregido en cotización de envíos internacionales
= 4.0.0 =
Cálculo multidivisa implementado
= 3.0.7 =
Bug corregido al mostrar nombres de paqueterías en cotización
= 3.0.6 =
Bug corregido al mostrar nombres de paqueterías en cotización
= 3.0.5 =
Nombres de paqueterías también se muestran en los resultados de la cotización
= 3.0.4 =
Bug corregido al descargar etiquetas de envío.
= 3.0.3 =
Bug corregido al obtener número de tracking.
= 3.0.2 =
Bug corregido al actualizar desde la versión 2.x
= 3.0.1 =
Bug corregido al actualizar desde la versión 2.x
= 3.0 =
Ahora es posible descargar las etiquetas de envío desde Wordpress.
= 2.2 =
Ahora cuenta con soporte para productos variables.
= 2.1 =
Optimización en tiempos de espera al consumir la API.
= 2.0 =
Se agrega la funcionalidad de agrupamiento de productos para productos pequeños que puedan meterse en un sólo paquete.
= 1.5 =
Se corrige un bug con la omisión de pago en checkout al seleccionar envío de Paquete.MX sin cobertura
= 1.4 =
Se corrige información del plugin
= 1.3 =
Se corrige la longitud máxima de campos de dirección de remitente
= 1.2 =
Se corrige un error al hacer un pedido con Pago contra entrega.
= 1.1 =
Se agrega compatibilidad con otros métodos de envío.
= 1.0 =
Esta es la primer versión del plugin Paquete.MX.

== Upgrade Notice ==

= 4.2.1 =
Validacion de extension mbstring.
= 4.2.1 =
Validacion de extension cURL y enlace a documentación mejor posicionada.
= 4.2.0 =
Retención de envío activada.
= 4.1.0 =
Tasa de incremento en costo de envío implementada.
= 4.0.0 =
Cálculo multidivisa implementado
= 3.0.7 =
En la cotización ya se muestran los nombres de las paqueterías
= 3.0.4 =
Bug corregido al descargar etiquetas de envío
= 3.0.3 =
Bugs en número de tracking corregido
= 3.0.2 =
Bugs menores corregidos
= 3.0.1 =
Bugs menores corregidos
= 3.0 =
Esta versión agrega un panel donde se podrán descargar las etiquetas de los envíos generados.
= 2.2 =
Esta versión añade la compatibilidad de los envíos con los productos variables de Woocommerce.
= 2.1 =
Esta versión ajusta los tiempos de espera al consumir la API de Paquete.mx, lo cual reduce significicativamente los errores 504 Timed Out.
= 2.0 =
Esta versión agrega una funcionalidad que permite agrupar varios productos en un mismo paquete para reducir el costo de los envíos. Es muy útil cuando en la tienda hay productos muy pequeños, y evita que se genere una etiqueta (multiparte) por cada producto en el carrito.
= 1.3 =
Esta versión corrige errores al generar envíos provocados por campos de dirección de remitente mayores a 30 y 22 caracteres.

== Funcionalidades ==

* Realiza los envíos de tus pedidos con FEDEX, UPS o Redpack.
* Descarga tus guías de envío directamente desde Wordpress.
* Calcula automáticamente el costo de los envíos antes de pagar.
* Selecciona qué paqueterías se van a considerar en el cálculo de tus envíos.
* Escoge si debe aparecer el costo del envío más rápido o el más barato.
* Realiza el proceso de envío automática o manualmente.
* Realiza el proceso de recolección automáticamente.