# **Documentación oficial de VERIFACTU:**

---
---

# DISEÑO DE REGISTROS DE FACTURACIÓN

## 1) DR Remisión Alta-Anul.VF-Req.


| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- |
| **Cabecera**¹ | **ObligadoEmision**¹ | **NombreRazon**¹ | Nombre-razón social del obligado a expedir las facturas. | Alfanumérico (120) |
| | | **NIF**¹ | NIF del obligado a expedir las facturas. | FormatoNIF (9) |
| | Representante | **NombreRazon**¹ | Nombre-razón social del representante del obligado tributario. A rellenar solo en caso de que los registros de facturación remitidos hayan sido generados por un representante/asesor del obligado tributario. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (120) |
| | | **NIF**¹ | NIF del representante del obligado tributario. A rellenar solo en caso de que los registros de facturación remitidos hayan sido generados por un representante/asesor del obligado tributario. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | FormatoNIF (9) |
| | RemisionVoluntaria | FechaFinVeriFactu | Última fecha en la que el sistema informático actuará como «VERIFACTU». Después de la misma, el sistema dejará de funcionar como «VERIFACTU». Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación actuales y futuros. A rellenar sólo en los casos de remisión voluntaria «VERIFACTU» ante una futura renuncia a continuar con las remisiones voluntarias «VERIFACTU». | Fecha (dd-mm-yyyy) |
| | | Incidencia | Indicador que especifica si la remisión voluntaria de los registros de facturación se ha visto afectada por algún tipo de incidencia técnica (por ej. ausencia de corriente eléctrica, problemas de conexión a Internet, fallo del sistema informático de facturación…). Si no se informa este campo se entenderá que tiene valor “N”. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. A rellenar sólo en los casos de remisión voluntaria «VERIFACTU» cuando haya ocurrido alguna situación de este tipo. | Alfanumérico (1) L4 |
| | RemisionRequerimiento | **RefRequerimiento**¹ | Sólo cuando el motivo de la remisión sea para dar respuesta a un requerimiento de información previo efectuado por parte de la AEAT, se deberá indicar aquí la referencia de dicho requerimiento, lo que forma parte del detalle de las circunstancias de generación del registro de facturación. Por lo tanto, NO deberá informarse este campo en el caso de una remisión voluntaria «VERIFACTU». | Alfanumérico (18) |
| | | FinRequerimiento | Indicador que especifica que se ha finalizado la remisión de registros de facturación tras un requerimiento, especialmente útil cuando se realice un envío o remisión múltiple y se ha de dejar constancia de que se trata del último envío. Si no se informa este campo se entenderá que tiene valor “N”. Solo puede cumplimentarse si el campo RefRequerimiento viene informado. | Alfanumérico (1) L4 |
| **RegistroFactura (1-1000)**¹ | **RegistroAlta**¹² | | Datos del registro de facturación de alta. Ver su diseño de bloque: «RegistroAlta». | |
| | **RegistroAnulacion**¹² | | Datos del registro de facturación de anulación. Ver su diseño de bloque: «RegistroAnulacion». | |
---
- La tabla contiene campos anidados.
- **Leyenda:** Las negritas y el superíndice ¹ significa campo obligatorio.
- **Leyenda:** El superíndice ² significa campo de selección.

---

## 2) D. Registro Facturación Alta
| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **RegistroAlta**¹ | **IDVersion**¹ | | | | Identificación de la versión actual del esquema o estructura de información utilizada para la generación y conservación / remisión de los registros de facturación. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (3) L15 |
| | **IDFactura**¹ | **IDEmisorFactura**¹ | | | Número de identificación fiscal (NIF) del obligado a expedir la factura. | FormatoNIF (9) |
| | | **NumSerieFactura**¹ | | | Nº Serie+Nº Factura que identifica a la factura emitida. | Alfanumérico (60) |
| | | **FechaExpedicionFactura**¹ | | | Fecha de expedición de la factura. | Fecha (dd-mm-yyyy) |
| | RefExterna | | | | Dato adicional de contenido libre con el objetivo de que se pueda asociar opcionalmente información interna del sistema informático de facturación al registro de facturación. Este dato puede ayudar a completar la identificación o calificación de la factura y/o su registro de facturación. | Alfanumérico (60) |
| | **NombreRazonEmisor**¹ | | | | Nombre-razón social del obligado a expedir la factura. | Alfanumérico (120) |
| | Subsanacion | | | | Indicador que especifica que se trata de una subsanación de un registro de facturación de alta previamente generado, por lo que el contenido de este nuevo registro de facturación es el correcto y el que deberá tenerse en cuenta. Si no se informa este campo se entenderá que tiene valor "N" (Alta Normal-Inicial). Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (1) L4 |
| | RechazoPrevio | | | | Indicador que especifica que se está generando -para volverlo a remitir- un nuevo registro de facturación de alta subsanado tras haber sido rechazado en su remisión inmediatamente anterior, es decir, en el último envío que contenía ese registro de facturación de alta rechazado. Si no se informa este campo se entenderá que tiene valor "N". Solo es necesario informarlo en caso de remisión voluntaria «VERIFACTU». Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (1) L17 |
| | **TipoFactura**¹ | | | | Especificación del tipo de factura: factura completa, factura simplificada, factura emitida en sustitución de facturas simplificadas o factura rectificativa. | Alfanumérico (2) L2 |
| | TipoRectificativa | | | | Campo que identifica si el tipo de factura rectificativa es por sustitución o por diferencia. | Alfanumérico (1) L3 |
| | FacturasRectificadas | **IDFacturaRectificada (1-1000)**¹ | **IDEmisorFactura**¹ | | NIF del obligado a expedir la factura. | FormatoNIF (9) |
| | | | **NumSerieFactura**¹ | | Nº Serie+Nº Factura que identifica a la factura emitida. | Alfanumérico (60) |
| | | | **FechaExpedicionFactura**¹ | | Fecha de expedición de la factura. | Fecha (dd-mm-yyyy) |
| | FacturasSustituidas | **IDFacturaSustituida (1-1000)**¹ | **IDEmisorFactura**¹ | | NIF del obligado a expedir la factura. | FormatoNIF (9) |
| | | | **NumSerieFactura**¹ | | Nº Serie+Nº Factura que identifica a la factura emitida. | Alfanumérico (60) |
| | | | **FechaExpedicionFactura**¹ | | Fecha de expedición de la factura. | Fecha (dd-mm-yyyy) |
| | ImporteRectificacion | **BaseRectificada**¹ | | | Base imponible de la factura. | Decimal (12,2) |
| | | **CuotaRectificada**¹ | | | Cuota repercutida o soportada de la factura. | Decimal (12,2) |
| | | CuotaRecargoRectificado | | | Cuota recargo de equivalencia de la factura. | Decimal (12,2) |
| | FechaOperacion | | | | Fecha en la que se ha realizado la operación siempre que sea diferente a la fecha de expedición. | Fecha (dd-mm-yyyy) |
| | **DescripcionOperacion**¹ | | | | Descripción del objeto de la factura. | Alfanumérico (500) |
| | FacturaSimplificadaArt7273 | | | | Factura simplificada Articulo 7.2 Y 7.3 RD 1619/2012. Si no se informa este campo se entenderá que tiene valor “N". | Alfanumérico (1) L4 |
| | FacturaSinIdentifDestinatarioArt61d | | | | Factura sin identificación destinatario artículo 6.1.d) RD 1619/2012. Si no se informa este campo se entenderá que tiene valor “N". | Alfanumérico (1) L5 |
| | Macrodato | | | | Identificador que especifica aquellas facturas con base o importe de la factura superior al umbral especificado. Este campo es necesario porque contribuye a completar el detalle de la tipología de la factura. Si no se informa este campo se entenderá que tiene valor “N”. | Alfanumérico (1) L14 |
| | EmitidaPorTerceroODestinatario | | | | Identificador que especifica si la factura ha sido expedida materialmente por un tercero o por el destinatario (contraparte). | Alfanumérico (1) L6 |
| | Tercero | **NombreRazon**¹ | | | Nombre-razón social del tercero que expida la factura. | Alfanumérico (120) |
| | | **NIF**¹² | | | Identificador del NIF del tercero que expida la factura. | FormatoNIF (9) |
| | | **IDOtro**¹² (campo selección) | CodigoPais | | Código del país del tercero que expida la factura. | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | | **IDType**¹ | | Clave para establecer el tipo de identificación del tercero en el país de residencia. | Alfanumérico (2) L7 |
| | | | **ID**¹ | | Número de identificación del tercero en el país de residencia. | Alfanumérico (20) |
| | Destinatarios | **IDDestinatario (1-1000)**¹ | **NombreRazon**¹ | | Nombre-razón social del destinatario (a veces también denominado contraparte, es decir, el cliente) de la operación. | Alfanumérico (120) |
| | | | **NIF**¹² | | Identificador del NIF del destinatario (a veces también denominado contraparte, es decir, el cliente) de la operación. | FormatoNIF (9) |
| | | | **IDOtro**¹² | CodigoPais | Código del país del destinatario (a veces también denominado contraparte, es decir, el cliente) de la operación de la factura expedida. | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | | | **IDType**¹ | Clave para establecer el tipo de identificación, en el país de residencia, del destinatario (a veces también denominado contraparte, es decir, el cliente) de la operación de la factura expedida. | Alfanumérico (2) L7 |
| | | | | **ID**¹ | Número de identificación, en el país de residencia, del destinatario (a veces también denominado contraparte, es decir, el cliente) de la operación de la factura expedida. | Alfanumérico (20) |
| | Cupon | | | | Identificador que especifica si tiene minoración de la base imponible por la concesión de cupones, bonificaciones o descuentos cuando solo se expide el original de la factura. Este campo es necesario porque contribuye a completar el detalle de la tipología de la factura. Si no se informa este campo se entenderá que tiene valor “N”. | Alfanumérico (1) L4 |
| | **Desglose**¹ | **DetalleDesglose (1-12)**¹ | Impuesto | | Impuesto de aplicación. Si no se informa este campo se entenderá que el impuesto de aplicación es el IVA. Este campo es necesario porque contribuye a completar el detalle de la tipología de la factura. | Alfanumérico (1) L1 |
| | | | ClaveRegimen | | Clave que identificará el tipo de régimen del impuesto o una operación con trascendencia tributaria. | Alfanumérico (2) L8A/L8B |
| | | | **CalificacionOperacion**¹ | | Clave de la operación sujeta y no exenta o de la operación no sujeta. | Alfanumérico (2) L9 |
| | | | **OperacionExenta**¹ | | Campo que especifica la causa de exención. | Alfanumérico (2) L10 |
| | | | TipoImpositivo | | Porcentaje aplicado sobre la base imponible para calcular la cuota. | Decimal (3,2) |
| | | | **BaseImponibleOimporteNoSujeto**¹ | | Magnitud dineraria sobre la que se aplica el tipo impositivo / Importe no sujeto. | Decimal (12,2) |
| | | | BaseImponibleACoste | | Magnitud dineraria sobre la que se aplica el tipo impositivo en régimen especial de grupos nivel avanzado. | Decimal (12,2) |
| | | | CuotaRepercutida | | Cuota resultante de aplicar a la base imponible el tipo impositivo. | Decimal (12,2) |
| | | | TipoRecargoEquivalencia | | Porcentaje asociado en función del impuesto y tipo impositivo | Decimal (3,2) |
| | | | CuotaRecargoEquivalencia | | Cuota resultante de aplicar a la base imponible el tipo de recargo de equivalencia. | Decimal (12,2) |
| | **CuotaTotal**¹ | | | | Importe total de la cuota (sumatorio de la Cuota Repercutida y Cuota de Recargo de Equivalencia). | Decimal (12,2) |
| | **ImporteTotal**¹ | | | | Importe total de la factura. Se detallará la forma de calcularlo en la documentación correspondiente en la sede electrónica de la AEAT (documento de validaciones...). | Decimal (12,2) |
| | **Encadenamiento**¹ | **PrimerRegistro**¹² | | | Indicador que especifica que no existe registro de facturación anterior en este sistema informático por tratarse del primer registro de facturación generado en él. En este caso, se informará con el valor "S". Si no se informa este campo se entenderá que no es el primer registro de facturación, en cuyo caso es obligatorio informar los campos de que consta «RegistroAnterior». | Alfanumérico (1) |
| | | **RegistroAnterior**¹² | **IDEmisorFactura**¹ | | NIF del obligado a expedir la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación, ya que es necesario para completar la identificación de la factura contenida en el registro de facturación anterior a encadenar en casos excepcionales y puntuales en los que no coincida con el actual, como al cambiar en un momento dado el NIF tras fusiones, absorciones, etc. | FormatoNIF (9) |
| | | | **NumSerieFactura**¹ | | Nº Serie+Nº Factura que identifica a la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Alfanumérico (60) |
| | | | **FechaExpedicionFactura**¹ | | Fecha de expedición de la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Fecha (dd-mm-yyyy) |
| | | | **Huella**¹ | | Primeros 64 caracteres de la huella o «hash» del registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Alfanumérico (64) |
| | **SistemaInformatico**¹ | | | | Datos del sistema informático de facturación utilizado. Ver su diseño de bloque: «SistemaInformatico». | |
| | **FechaHoraHusoGenRegistro**¹ | | | | Fecha, hora y huso horario de generación del registro de facturación. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del registro de facturación. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | NumRegistroAcuerdoFacturacion | | | | Número de registro obtenido al enviar la autorización en materia de facturación o de libros registro a que se refiere la disposición adicional primera del Real Decreto que aprueba el Reglamento. Este campo forma parte del detalle de las circunstancias de generación del registro de facturación. | Alfanumérico (15) |
| | IdAcuerdoSistemaInformatico | | | | Identificación del acuerdo (resolución) a que se refiere el artículo 5 del Reglamento. Este campo forma parte del detalle de las circunstancias de generación del registro de facturación. | Alfanumérico (16) |
| | **TipoHuella**¹ | | | | Tipo de algoritmo aplicado a cierto contenido del registro de facturación para obtener la huella o «hash». | Alfanumérico (2) L12 |
| | **Huella**¹ | | | | Huella o «hash» de cierto contenido de este registro de facturación. Dicho contenido se detallará en la documentación correspondiente en la sede electrónica de la AEAT (documento de huella...). | Alfanumérico (64) |
| | Signature | | | | Firma electrónica del registro de facturación en formato Xades Enveloped<br>Namespace=http://www.w3.org/2000/09/xmldsig#.<br>Obligatorio para conservación y para requerimiento, pero no para remisión voluntaria («VERIFACTU»). | Ver formato del "schema", en http://www.w3.org/2000/09/xmldsig# |

---
- La tabla contiene campos anidados.
- **Leyenda:** Las negritas y El superíndice ¹ significa campo obligatorio.
- **Leyenda:** El superíndice ² significa campo de selección.

---

## **3) Diseño Reg. Facturación Anulación**

Claro, aquí tienes la tabla en formato Markdown.

| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **RegistroAnulacion**¹ | **IDVersion**¹ | | | Identificación de la versión actual del esquema o estructura de información utilizada para la generación y conservación / remisión de los registros de facturación. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (3) L15 |
| | **IDFactura**¹ | **IDEmisorFacturaAnulada**¹ | | NIF del obligado a expedir la factura que se anula. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación, ya que es necesario para completar la identificación de la factura a anular en casos excepcionales y puntuales en los que no coincida con el actual, como al cambiar en un momento dado el NIF tras fusiones, absorciones, etc. | FormatoNIF (9) |
| | | **NumSerieFacturaAnulada**¹ | | Nº Serie+Nº Factura que identifica a la factura que se anula. | Alfanumérico (60) |
| | | **FechaExpedicionFacturaAnulada**¹ | | Fecha de expedición de la factura que se anula. | Fecha (dd-mm-yyyy) |
| | RefExterna | | | Dato adicional de contenido libre con el objetivo de que se pueda asociar opcionalmente información interna del sistema informático de facturación al registro de facturación. Este dato puede ayudar a completar la identificación o calificación de la factura y/o su registro de facturación. | Alfanumérico (60) |
| | SinRegistroPrevio | | | Indicador que especifica que se trata de la anulación de un registro de facturación de alta (o subsanación de un registro de facturación de anulación previo) cuando este no existe en la AEAT (o en el propio sistema informático, si así procede indicar). Si no se informa este campo se entenderá que tiene valor "N". Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (1) L4 |
| | RechazoPrevio | | | Indicador que especifica que se está generando -para volverlo a remitir- un nuevo registro de facturación de anulación subsanado tras haber sido rechazado en su remisión inmediatamente anterior, es decir, en el último envío que contenía ese registro de facturación de anulación rechazado. Si no se informa este campo se entenderá que tiene valor "N". Solo es necesario informarlo en caso de remisión voluntaria «VERIFACTU». Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación. | Alfanumérico (1) L4 |
| | GeneradoPor | | | Indicador que especifica quién se ha encargado de generar materialmente el registro de facturación de anulación, cuyos datos identificativos deberán hacerse constar dentro del grupo de campos "Generador", en su correspondiente sitio en función de si dispone de NIF o no. Si no se informa este campo, tampoco se deberá informar "Generador", considerándose que es el mismo que el emisor material de la factura que se anula. Por otro lado, se entiende que el obligado a generar el registro de facturación de anulación siempre es el mismo que el obligado a expedir la factura que en él se anula (incluyendo los casos de sucesión). | Alfanumérico (1) L16 |
| | Generador | **NombreRazon**¹ | | Nombre-razón social del generador material del registro de facturación de anulación. | Alfanumérico (120) |
| | | **NIF**¹² | | En su caso, identificador del NIF del generador material del registro de facturación de anulación. | FormatoNIF (9) |
| | | **IDOtro**¹² | CodigoPais | En su caso, código del país del generador material del registro de facturación de anulación. | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | | **IDType**¹ | En su caso, clave para establecer el tipo de identificación, en el país de residencia, del generador material del registro de facturación de anulación. | Alfanumérico (2) L7 |
| | | | **ID**¹ | En su caso, número de identificación, en el país de residencia, del generador material del registro de facturación de anulación. | Alfanumérico (20) |
| | **Encadenamiento**¹ | **PrimerRegistro**¹² | | Indicador que especifica que no existe registro de facturación anterior en este sistema informático por tratarse del primer registro de facturación generado en él. En este caso, se informará con el valor "S". Si no se informa este campo se entenderá que no es el primer registro de facturación, en cuyo caso es obligatorio informar los campos de que consta «RegistroAnterior». | Alfanumérico (1) |
| | | **RegistroAnterior**¹² | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. Este campo forma parte del detalle de las circunstancias de generación de los registros de facturación, ya que es necesario para completar la identificación de la factura contenida en el registro de facturación anterior a encadenar en casos excepcionales y puntuales en los que no coincida con el actual, como al cambiar en un momento dado el NIF tras fusiones, absorciones, etc. | FormatoNIF (9) |
| | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura que identifica a la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Alfanumérico (60) |
| | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura a que se refiere el registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Fecha (dd-mm-yyyy) |
| | | | **Huella**¹ | Primeros 64 caracteres de la huella o «hash» del registro de facturación anterior (sea de alta o de anulación) generado en este sistema informático. | Alfanumérico (64) |
| | **SistemaInformatico**¹ | | | Datos del sistema informático de facturación utilizado. Ver su diseño de bloque: «SistemaInformatico». | |
| | **FechaHoraHusoGenRegistro**¹ | | | Fecha, hora y huso horario de generación del registro de facturación. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del registro de facturación. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | **TipoHuella**¹ | | | Tipo de algoritmo aplicado a cierto contenido del registro de facturación para obtener la huella o «hash». | Alfanumérico (2) L12 |
| | **Huella**¹ | | | Huella o «hash» de cierto contenido de este registro de facturación. Dicho contenido se detallará en la documentación correspondiente en la sede electrónica de la AEAT (documento de huella...). | Alfanumérico (64) |
| | Signature | | | Firma electrónica del registro de facturación en formato Xades Enveloped.<br>Namespace=http://www.w3.org/2000/09/xmldsig#<br>Obligatorio para conservación y para requerimiento, pero no para remisión voluntaria («VERIFACTU»). | Ver formato del "schema", en http://www.w3.org/2000/09/xmldsig# |

---
- La tabla contiene campos anidados.
- **Leyenda:** Las negritas y el superíndice ¹ significa campo obligatorio.
- **Leyenda:** El superíndice ² significa campo de selección.

---

## 4) Diseño Registro Evento


| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **RegistroEvento**¹ | **IDVersion**¹ | | | | | Identificación de la versión actual del esquema o estructura de información utilizada para la generación y conservación de los registros de evento. | Alfanumérico (3)<br>L15 |
| | **Evento**¹ | **SistemaInformatico**¹ | | | | Datos del sistema informático de facturación utilizado. Ver su diseño de bloque: «SistemaInformatico». | |
| | | **ObligadoEmision**¹ | **NombreRazon**¹ | | | Nombre-razón social del obligado a expedir las facturas. | Alfanumérico (120) |
| | | | **NIF**¹ | | | NIF del obligado a expedir las facturas. | FormatoNIF (9) |
| | | EmitidaPorTerceroODestinatario | | | | Campo que especifica si las facturas son expedidas materialmente por un tercero o destinatario en nombre del obligado a expedir facturas, en cuyo caso el campo «TerceroODestinatario» es obligatorio. Si no se informa este indicador, se entiende que quien expide materialmente las facturas (y genera los correspondientes registros de facturación) es el propio obligado a expedir las facturas. | Alfanumérico (1)<br>L4E |
| | | TerceroODestinatario | **NombreRazon**¹ | | | Nombre-razón social del tercero o destinatario que expida las facturas. | Alfanumérico (120) |
| | | | **NIF**¹² | | | NIF del tercero o destinatario que expida las facturas. | FormatoNIF (9) |
| | | | **IDOtro**¹² | CodigoPais | | Código del país del tercero o destinatario que expida las facturas. | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | | | **IDType**¹ | | Clave para establecer el tipo de identificación en el país de residencia. | Alfanumérico (2)<br>L7 |
| | | | | **ID**¹ | | Número de identificación en el país de residencia. | Alfanumérico (20) |
| | | **FechaHoraHusoGenEvento**¹ | | | | Fecha, hora y huso horario de generación del registro de evento. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | **TipoEvento**¹ | | | | Tipo de evento que se está registrando. | Alfanumérico (2) L2E |
| | | R | **LanzamientoProcesoDeteccionAnomaliasRegFacturacion**¹² | **RealizadoProcesoSobreIntegridadHuellasRegFacturacion**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la integridad de las huellas de los registros de facturación. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosFacturacionProcesadosSobreIntegridadHuellas | | Número de registros de facturación analizados por el proceso sobre la integridad de las huellas. Obligatorio si el campo anterior es igual a "S" | Numérico (7) |
| | | | | **RealizadoProcesoSobreIntegridadFirmasRegFacturacion**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la integridad de las firmas de los registros de facturación. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosFacturacionProcesadosSobreIntegridadFirmas | | Número de registros de facturación analizados por el proceso sobre la integridad de la firma. Obligatorio si el campo anterior es igual a "S". | Numérico (7) |
| | | | | **RealizadoProcesoSobreTrazabilidadCadenaRegFacturacion**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la trazabilidad del encadenamiento de los registros de facturación. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosFacturacionProcesadosSobreTrazabilidadCadena | | Número de registros de facturación analizados por el proceso sobre la trazabilidad del encadenamiento. Obligatorio si el campo anterior es igual a "S". | Numérico (7) |
| | | | | **RealizadoProcesoSobreTrazabilidadFechasRegFacturacion**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la trazabilidad de las fechas de los registros de facturación. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosFacturacionProcesadosSobreTrazabilidadFechas | | Número de registros de facturación analizados por el proceso sobre la trazabilidad de las fechas. Obligatorio si el campo anterior es igual a "S". | Numérico (7) |
| | | | **DeteccionAnomaliasRegFacturacion**¹² | **TipoAnomalia**¹ | | Tipo de anomalía detectado. | Alfanumérico (2) L1E |
| | | | | OtrosDatosAnomalia | | Otros datos de interés o explicación adicional que el sistema informático pueda aportar sobre la anomalía detectada. | Alfanumérico (100) |
| | | | | RegistroFacturacionAnomalo | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el registro de facturación anómalo. | FormatoNIF (9) |
| | | | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura a que se refiere el registro de facturación anómalo. | Alfanumérico (60) |
| | | | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura a que se refiere el registro de facturación anómalo. | Fecha (dd-mm-yyyy) |
| | | | **LanzamientoProcesoDeteccionAnomaliasRegEvento**¹² | **RealizadoProcesoSobreIntegridadHuellasRegEvento**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la integridad de las huellas de los registros de evento. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosEventoProcesadosSobreIntegridadHuellas | | Número de registros de evento analizados por el proceso sobre la integridad de las huellas. Obligatorio si el campo anterior es igual a "S". | Numérico (5) |
| | | | | **RealizadoProcesoSobreIntegridadFirmasRegEvento**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la integridad de las firmas de los registros de evento. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosEventoProcesadosSobreIntegridadFirmas | | Número de registros de evento analizados por el proceso sobre la integridad de la firma. Obligatorio si el campo anterior es igual a "S". | Numérico (5) |
| | | | | **RealizadoProcesoSobreTrazabilidadCadenaRegEvento**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la trazabilidad del encadenamiento de los registros de evento. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosEventoProcesadosSobreTrazabilidadCadena | | Número de registros de evento analizados por el proceso sobre la trazabilidad del encadenamiento. Obligatorio si el campo anterior es igual a "S". | Numérico (5) |
| | | | | **RealizadoProcesoSobreTrazabilidadFechasRegEvento**¹ | | Indica si se ha lanzado algún proceso de detección de anomalías sobre la trazabilidad de las fechas de los registros de evento. | Alfanumérico (1) L3E |
| | | | | NumeroDeRegistrosEventoProcesadosSobreTrazabilidadFechas | | Número de registros de evento analizados por el proceso sobre la trazabilidad de las fechas. Obligatorio si el campo anterior es igual a "S". | Numérico (5) |
| | | | **DeteccionAnomaliasRegEvento**¹² | **TipoAnomalia**¹ | | Tipo de anomalía detectada. | Alfanumérico (2) L1E |
| | | | | OtrosDatosAnomalia | | Otros datos de interés o explicación adicional que el sistema informático pueda aportar sobre la anomalía detectada. | Alfanumérico (100) |
| | | | | RegEventoAnomalo | **TipoEvento**¹ | Tipo de evento detectado como anómalo. | Alfanumérico (2) L2E |
| | | | | | **FechaHoraHusoEvento**¹ | Fecha hora y huso del evento detectado como anómalo. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | | **HuellaEvento**¹ | Huella del evento detectado como anómalo. | Alfanumérico (64) |
| | | | **ExportacionRegFacturacionPeriodo**¹² | **FechaHoraHusoInicioPeriodoExport**¹ | | Fecha, hora y huso horario inicial del período a exportar. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | **FechaHoraHusoFinPeriodoExport**¹ | | Fecha, hora y huso horario final del período a exportar. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | **RegistroFacturacionInicialPeriodo**¹ | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el primer registro de facturación del período exportado. | FormatoNIF (9) |
| | | | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura de la factura a que se refiere el primer registro de facturación del período. | Alfanumérico (60) |
| | | | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura a que se refiere el primer registro de facturación del período. | Fecha (dd-mm-yyyy) |
| | | | | | **Huella**¹ | Huella del primer registro de facturación del período. | Alfanumérico (64) |
| | | | | **RegistroFacturacionFinalPeriodo**¹ | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el último registro de facturación del período exportado. | FormatoNIF (9) |
| | | | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura de la factura a que se refiere el último registro de facturación del período. | Alfanumérico (60) |
| | | | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura correspondiente al último registro de facturación del período. | Fecha (dd-mm-yyyy) |
| | | | | | **Huella**¹ | Huella del último registro de facturación del período. | Alfanumérico (64) |
| | | | | **NumeroDeRegistrosFacturacionAltaExportados**¹ | | Número de registros de facturación de alta exportados para el período. | Numérico (9) |
| | | | | **SumaCuotaTotalAlta**¹ | | Suma de la Cuota total de las facturas de todos los registros de facturación de alta exportados para el período. | Decimal (12,2) |
| | | | | **SumaImporteTotalAlta**¹ | | Suma del Importe total de las facturas de todos los registros de facturación de alta exportados para el período. | Decimal (12,2) |
| | | | | **NumeroDeRegistrosFacturacionAnulacionExportados**¹ | | Número de registros de facturación de anulación exportados para el período. | Numérico (9) |
| | | | | **RegistrosFacturacionExportadosDejanDeConservarse**¹ | | Indica si los registros de facturación exportados para el período dejan (o no) de conservarse en el sistema informático. | Alfanumérico (1) L3E |
| | | | **ExportacionRegEventoPeriodo**¹² | **FechaHoraHusoInicioPeriodoExport**¹ | | Fecha, hora y huso horario inicial del período a exportar (registros de evento). El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | **FechaHoraHusoFinPeriodoExport**¹ | | Fecha, hora y huso horario final del período a exportar (registros de evento). El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | **RegistroEventoInicialPeriodo**¹ | **TipoEvento**¹ | Tipo de evento del primer reg. de evento del período exportado. | Alfanumérico (2) L2E |
| | | | | | **FechaHoraHusoEvento**¹ | Fecha, hora y huso horario del primer reg. de evento del período exportado. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | | **HuellaEvento**¹ | Huella del primer registro de evento del período. | Alfanumérico (64) |
| | | | | **RegistroEventoFinalPeriodo**¹ | **TipoEvento**¹ | Tipo de evento del último reg. de evento del período exportado. | Alfanumérico (2) L2E |
| | | | | | **FechaHoraHusoEvento**¹ | Fecha, hora y huso horario del último reg. de evento del período exportado. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | | **HuellaEvento**¹ | Huella del último registro de evento del período. | Alfanumérico (64) |
| | | | | **NumeroDeRegEventoExportados**¹ | | Número de registros de evento exportados para el período indicado. | Numérico (7) |
| | | | | **RegEventoExportadosDejanDeConservarse**¹ | | Indica si los registros de evento exportados para el período indicado dejan de conservarse (o no) en el sistema informático. | Alfanumérico (1) L3E |
| | | | **ResumenEventos**¹² | **TipoEvento (1-20)**¹ | **TipoEvento**¹ | Tipo de evento al que va a referirse la información que va a inmediatamente a continuación de este campo. | Alfanumérico (2) L2E |
| | | | | | **NumeroDeEventos**¹ | Número de eventos del tipo que indica el campo anterior que se han producido en el período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Numérico (4) |
| | | | | RegistroFacturacionInicialPeriodo | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el primer registro de facturación del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | FormatoNIF (9) |
| | | | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura de la factura a que se refiere el primer registro de facturación del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Alfanumérico (60) |
| | | | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura a que se refiere el primer registro de facturación del período. | Fecha (dd-mm-yyyy) |
| | | | | | **Huella**¹ | Huella del primer registro de facturación del período. | Alfanumérico (64) |
| | | | | RegistroFacturacionFinalPeriodo | **IDEmisorFactura**¹ | NIF del obligado a expedir la factura a que se refiere el último registro de facturación del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | FormatoNIF (9) |
| | | | | | **NumSerieFactura**¹ | Nº Serie+Nº Factura de la factura a que se refiere el último registro de facturación del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Alfanumérico (60) |
| | | | | | **FechaExpedicionFactura**¹ | Fecha de expedición de la factura correspondiente al último registro de facturación del período. | Fecha (dd-mm-yyyy) |
| | | | | | **Huella**¹ | Huella del último registro de facturación del período. | Alfanumérico (64) |
| | | | | **NumeroDeRegistrosFacturacionAltaGenerados**¹ | | Número de registros de facturación de alta generados en el período(desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Numérico (6) |
| | | | | **SumaCuotaTotalAlta**¹ | | Suma de la Cuota total de las facturas de todos los registros de facturación de alta del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Decimal (12,2) |
| | | | | **SumaImporteTotalAlta**¹ | | Suma del Importe total de las facturas de todos los registros de facturación de alta del período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Decimal (12,2) |
| | | | | **NumeroDeRegistrosFacturacionAnulacionGenerados**¹ | | Número de registros de facturación de anulación generados en el período (desde que se generó el último registro de resumen de eventos hasta el actual registro de resumen de eventos que se está generando). | Numérico (6) |
| | | OtrosDatosEvento | | | | Cualquier dato o conjunto de datos adicionales que el sistema informático considere de interés sobre el evento registrado. | Alfanumérico (100) |
| | | **Encadenamiento**¹ | **PrimerEvento**¹² | | | Indicador que especifica que no existe registro de evento anterior en este sistema informático por tratarse del primer registro de evento generado en él. En este caso, se informará con el valor "S". Si no se informa este campo se entenderá que no es el primer registro de evento, en cuyo caso es obligatorio informar los campos de que consta «EventoAnterior». | Alfanumérico (1) |
| | | | **EventoAnterior**¹² | **TipoEvento**¹ | | Tipo de registro de evento anterior. | Alfanumérico (2) L2E |
| | | | | **FechaHoraHusoGenEvento**¹ | | Fecha, hora y huso horario de generación del registro de evento anterior. El huso horario es el que está usando el sistema informático de facturación en el momento de generación del registro de evento. | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| | | | | **HuellaEvento**¹ | | Primeros 64 caracteres de la huella o «hash» del registro de evento anterior. | Alfanumérico (64) |
| | | **TipoHuella**¹ | | | | Tipo de algoritmo aplicado a cierto contenido del registro de evento para obtener la huella o «hash». | Alfanumérico (2) L12 |
| | | **HuellaEvento**¹ | | | | Huella o «hash» de cierto contenido de este registro de evento. Dicho contenido se detallará en la documentación correspondiente en la sede electrónica de la AEAT (documento de huella...). | Alfanumérico (64) |
| | **Signature**¹ | | | | | Firma electrónica del registro de evento en formato Xades Enveloped<br>Namespace=http://www.w3.org/2000/09/xmldsig# | Ver formato del "schema", en http://www.w3.org/2000/09/xmldsig# |

---
- La tabla contiene campos anidados.
- **Leyenda:** Las negritas y el superíndice ¹ significa campo obligatorio.
- **Leyenda:** El superíndice ² significa campo de selección.

---

## 5) Definición SistemaInformatico

| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- |
| **SistemaInformatico**¹ | **NombreRazon**¹ | | Nombre-razón social de la persona o entidad productora (ver * NOTA aclaratoria al final del bloque «SistemaInformatico»). | Alfanumérico (120) |
| | **NIF**¹² | | NIF de la persona o entidad productora (ver * NOTA aclaratoria al final del bloque «SistemaInformatico»). | FormatoNIF (9) |
| | **IDOtro**¹² | CodigoPais | Código del país de la persona o entidad productora (ver * NOTA aclaratoria al final del bloque «SistemaInformatico»). | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | **IDType**¹ | Clave para establecer el tipo de identificación de la persona o entidad productora (ver * NOTA aclaratoria al final del bloque «SistemaInformatico»). | Alfanumérico (2) L7 |
| | | **ID**¹ | Número de identificación de la persona o entidad productora (ver * NOTA aclaratoria al final del bloque «SistemaInformatico») en el país de residencia. | Alfanumérico (20) |
| | NombreSistemaInformatico | | Nombre dado por la persona o entidad productora a su sistema informático de facturación (SIF) que, una vez instalado, se constituye en el SIF utilizado. Obligatorio en registros de facturación de alta y de anulación, y opcional en registros de evento. | Alfanumérico (30) |
| | **IdSistemaInformatico**¹ | | Código identificativo dado por la persona o entidad productora a su sistema informático de facturación (SIF) que, una vez instalado, se constituye en el SIF utilizado. Deberá distinguirlo de otros posibles SIF distintos que produzca esta misma persona o entidad productora. Se detallarán las posibles restricciones a sus valores en la documentación correspondiente en la sede electrónica de la AEAT (documento de validaciones...). | Alfanumérico (2) |
| | **Version**¹ | | Identificación de la versión del sistema informático de facturación (SIF) que se ejecuta en el sistema informático de facturación utilizado. | Alfanumérico (50) |
| | **NumeroInstalacion**¹ | | Número de instalación del sistema informático de facturación (SIF) utilizado. Deberá distinguirlo de otros posibles SIF utilizados para realizar la facturación del obligado a expedir facturas, es decir, de otras posibles instalaciones de SIF pasadas, presentes o futuras utilizadas para realizar la facturación del obligado a expedir facturas, incluso aunque en dichas instalaciones se emplee el mismo SIF de un productor. | Alfanumérico (100) |
| | TipoUsoPosibleSoloVerifactu | | Especifica si para cumplir el Reglamento el sistema informático de facturación solo puede funcionar exclusivamente como «VERIFACTU» (valor "S") o puede funcionar también como «NO VERIFACTU» (valor "N"). Obligatorio en registros de facturación de alta y de anulación. No aplica en registros de evento. | Alfanumérico (1) L4 |
| | TipoUsoPosibleMultiOT | | Especifica si el sistema informático de facturación permite llevar independientemente la facturación de varios obligados tributarios (valor "S") o solo de uno (valor "N"). Obligatorio en registros de facturación de alta y de anulación, y opcional en registros de evento. | Alfanumérico (1) L4 |
| | IndicadorMultiplesOT | | Indicador de que el sistema informático, en el momento de la generación de este registro, está soportando la facturación de más de un obligado tributario. Este valor deberá obtenerlo automáticamente el sistema informático a partir del número de obligados tributarios contenidos y/o gestionados en él en ese momento, independientemente de su estado operativo (alta, baja...), no pudiendo obtenerse a partir de otra información ni ser introducido directamente por el usuario del sistema informático ni cambiado por él. El valor "N" significará que el sistema informático solo contiene y/o gestiona un único obligado tributario (de alta o de baja o en cualquier otro estado), que se corresponderá con el obligado a expedir factura de este registro de facturación. En cualquier otro caso, se deberá informar este campo con el valor "S". Obligatorio en registros de facturación de alta y de anulación, y opcional en registros de evento. | Alfanumérico (1) L4 |

---
- La tabla contiene campos anidados.
**NOTA:** dato de la persona o entidad productora del sistema informático de facturación (SIF) empleado. En el caso de haber varios productores (por ejemplo, cuando el SIF consta de varios componentes de distintos productores) se deberán consignar los datos del productor responsable del componente principal del SIF, según la definición dada en el artículo 1.2.c) de esta orden.
- **Leyenda:** Las negritas y el superíndice ¹ significa campo obligatorio.
- **Leyenda:** El superíndice ² significa campo de selección.

---

## 6) Listas

#### L1
- 01: Impuesto sobre el Valor Añadido (IVA)
- 02: Impuesto sobre la Producción, los Servicios y la Importación (IPSI) de Ceuta y Melilla
- 03: Impuesto General Indirecto Canario (IGIC)
- 05: Otros

#### L2
- F1: Factura (art. 6, 7.2 y 7.3 del RD 1619/2012)
- F2: Factura Simplificada y Facturas sin identificación del destinatario art. 6.1.d) RD 1619/2012
- F3: Factura emitida en sustitución de facturas simplificadas facturadas y declaradas
- R1: Factura Rectificativa (Error fundado en derecho y Art. 80 Uno Dos y Seis LIVA)
- R2: Factura Rectificativa (Art. 80.3)
- R3: Factura Rectificativa (Art. 80.4)
- R4: Factura Rectificativa (Resto)
- R5: Factura Rectificativa en facturas simplificadas
> **NOTA:** las menciones a la LIVA (Ley 37/1992, de 28 de diciembre, del Impuesto sobre el Valor Añadido) en la lista L2 deben entenderse realizadas, en su caso, a la normativa equivalente de Canarias, Ceuta y Melilla

#### L3
- S: Por sustitución
- I: Por diferencias

#### L4
- S: Sí
- N: No

#### L5
- S: Sí
- N: No

#### L6
- D: Destinatario
- T: Tercero

#### L7
- 02: NIF-IVA
- 03: Pasaporte
- 04: Documento oficial de identificación expedido por el país o territorio de residencia
- 05: Certificado de residencia
- 06: Otro documento probatorio
- 07: No censado

#### L8A - DESCRIPCIÓN DE LA CLAVE DE RÉGIMEN PARA DESGLOSES DONDE EL IMPUESTO DE APLICACIÓN ES EL IVA
- 01: Operación de régimen general.
- 02: Exportación.
- 03: Operaciones a las que se aplique el régimen especial de bienes usados, objetos de arte, antigüedades y objetos de colección.
- 04: Régimen especial del oro de inversión.
- 05: Régimen especial de las agencias de viajes.
- 06: Régimen especial grupo de entidades en IVA (Nivel Avanzado)
- 07: Régimen especial del criterio de caja.
- 08: Operaciones sujetas al IPSI / IGIC (Impuesto sobre la Producción, los Servicios y la Importación / Impuesto General Indirecto Canario).
- 09: Facturación de las prestaciones de servicios de agencias de viaje que actúan como mediadoras en nombre y por cuenta ajena (D.A.4ª RD1619/2012)
- 10: Cobros por cuenta de terceros de honorarios profesionales o de derechos derivados de la propiedad industrial, de autor u otros por cuenta de sus socios, asociados o colegiados efectuados por sociedades, asociaciones, colegios profesionales u otras entidades que realicen estas funciones de cobro.
- 11: Operaciones de arrendamiento de local de negocio.
- 14: Factura con IVA pendiente de devengo en certificaciones de obra cuyo destinatario sea una Administración Pública.
- 15: Factura con IVA pendiente de devengo en operaciones de tracto sucesivo.
- 17: Operación acogida a alguno de los regímenes previstos en el Capítulo XI del Título IX (OSS e IOSS)
- 18: Recargo de equivalencia.
- 19: Operaciones de actividades incluidas en el Régimen Especial de Agricultura, Ganadería y Pesca (REAGYP)
- 20: Régimen simplificado

#### L8B - DESCRIPCIÓN DE LA CLAVE DE RÉGIMEN PARA DESGLOSES DONDE EL IMPUESTO DE APLICACIÓN ES EL IGIC
- 01: Operación de régimen general.
- 02: Exportación.
- 03: Operaciones a las que se aplique el régimen especial de bienes usados, objetos de arte, antigüedades y objetos de colección.
- 04: Régimen especial del oro de inversión.
- 05: Régimen especial de las agencias de viajes.
- 06: Régimen especial grupo de entidades en IGIC (Nivel Avanzado)
- 07: Régimen especial del criterio de caja.
- 08: Operaciones sujetas al IPSI / IVA (Impuesto sobre la Producción, los Servicios y la Importación / Impuesto sobre el Valor Añadido).
- 09: Facturación de las prestaciones de servicios de agencias de viaje que actúan como mediadoras en nombre y por cuenta ajena (D.A.4ª RD1619/2012)
- 10: Cobros por cuenta de terceros de honorarios profesionales o de derechos derivados de la propiedad industrial, de autor u otros por cuenta de sus socios, asociados o colegiados efectuados por sociedades, asociaciones, colegios profesionales u otras entidades que realicen estas funciones de cobro.
- 11: Operaciones de arrendamiento de local de negocio.
- 14: Factura con IGIC pendiente de devengo en certificaciones de obra cuyo destinatario sea una Administración Pública.
- 15: Factura con IGIC pendiente de devengo en operaciones de tracto sucesivo.
- 17: Régimen especial de comerciante minorista
- 18: Régimen especial del pequeño empresario o profesional
- 19: Operaciones interiores exentas por aplicación artículo 25 Ley 19/1994

#### L9
- S1: Operación Sujeta y No exenta - Sin inversión del sujeto pasivo.
- S2: Operación Sujeta y No exenta - Con Inversión del sujeto pasivo
- N1: Operación No Sujeta artículo 7, 14, otros.
- N2: Operación No Sujeta por Reglas de localización.

#### L10
- E1: Exenta por el artículo 20
- E2: Exenta por el artículo 21
- E3: Exenta por el artículo 22
- E4: Exenta por los artículos 23 y 24
- E5: Exenta por el artículo 25
- E6: Exenta por otros

#### L12
- 01: SHA-256

#### L14
- S: Sí
- N: No

#### L15
- 1.0: Versión actual (1.0) del esquema utilizado

#### L16
- E: Expedidor (obligado a Expedir la factura anulada).
- D: Destinatario
- T: Tercero

#### L17
- N: No ha habido rechazo previo por la AEAT.
- S: Ha habido rechazo previo por la AEAT. No deberían existir operaciones de alta con valores ('Subsanacion'="N" y 'RechazoPrevio'="S"), por lo que no se admiten.
- X: Independientemente de si ha habido o no algún rechazo previo por la AEAT, el registro de facturación no existe en la AEAT (registro existente en ese sistema informático o en algún sistema informático del obligado tributario y que no se remitió a la AEAT, por ejemplo, al acogerse a la modalidad «VERIFACTU» desde la modalidad «NO VERIFACTU»). No deberían existir operaciones de alta con valores ('Subsanacion'="N" y 'RechazoPrevio'="X"), por lo que no se admiten.

#### L1E
- 01: Integridad-huella
- 02: Integridad-firma
- 03: Integridad - Otros
- 04: Trazabilidad-cadena-registro - Reg. no primero pero con reg. anterior no anotado o inexistente
- 05: Trazabilidad-cadena-registro - Reg. no último pero con reg. posterior no anotado o inexistente
- 06: Trazabilidad-cadena-registro - Otros
- 07: Trazabilidad-cadena-huella - Huella del reg. no se corresponde con la 'huella del reg. anterior' almacenada en el registro posterior
- 08: Trazabilidad-cadena-huella - Campo 'huella del reg. anterior' no se corresponde con la huella del reg. anterior
- 09: Trazabilidad-cadena-huella - Otros
- 10: Trazabilidad-cadena - Otros
- 11: Trazabilidad-fechas - Fecha-hora anterior a la fecha del reg. anterior
- 12: Trazabilidad-fechas - Fecha-hora posterior a la fecha del reg. posterior
- 13: Trazabilidad-fechas - Reg. con fecha-hora de generación posterior a la fecha-hora actual del sistema
- 14: Trazabilidad-fechas - Otros
- 15: Trazabilidad - Otros
- 90: Otros

#### L2E
- 01: Inicio del funcionamiento del sistema informático como «NO VERIFACTU».
- 02: Fin del funcionamiento del sistema informático como «NO VERIFACTU».
- 03: Lanzamiento del proceso de detección de anomalías en los registros de facturación.
- 04: Detección de anomalías en la integridad, inalterabilidad y trazabilidad de registros de facturación.
- 05: Lanzamiento del proceso de detección de anomalías en los registros de evento.
- 06: Detección de anomalías en la integridad, inalterabilidad y trazabilidad de registros de evento.
- 07: Restauración de copia de seguridad, cuando ésta se gestione desde el propio sistema informático de facturación.
- 08: Exportación de registros de facturación generados en un periodo.
- 09: Exportación de registros de evento generados en un periodo.
- 10: Registro resumen de eventos
- 90: Otros tipos de eventos a registrar voluntariamente por la persona o entidad productora del sistema informático.

#### L3E
- S: Sí
- N: No

#### L4E
- D: Destinatario
- T: Tercero

--

## 7 Operativas de alta y anulacion

### 7.A) Cuadro Operativa Alta

| Tipo | Operación | Descripción | Operativa | Tipo SIF al que aplica | Condiciones | Consecuencias | Situación AEAT: No existe registro | Situación AEAT: Existe registro de alta | Situación AEAT: Existe registro de anulación |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **ALTA DE REGISTRO** |
| ⚪️ Operativa Normal | **ALTA** | · Alta inicial ("normal") del registro de facturación.<br>· Es el alta habitual de un registro de facturación. | · No informar `<Subsanacion>` o informarlo con valor N<br>· No informar `<RechazoPrevio>` o informarlo con valor N | · VERIFACTU<br>· NO VERIFACTU | El registro de facturación no debe existir previamente en SIF del obligado / AEAT. | Alta del registro de facturación con los nuevos datos. | ✅ OK(1) | ❌ ERROR(2) | ❌ ERROR(2) |
| 🔘 Operativa Especial | **ALTA POR RECHAZO** | · Alta por rechazo del registro de facturación de alta inicial (y que, por tanto, no existe aún en la AEAT).<br>· Es la subsanación de datos de un registro de facturación de alta inicial, cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · `<Subsanacion>`=S<br>· `<RechazoPrevio>`=X | · VERIFACTU | · La clave única del registro de facturación no debe existir previamente en la AEAT.<br>· El alta previa del registro de facturación fue rechazada. | Alta del registro de facturación con los nuevos datos. | ✅ OK(1) | ❌ ERROR(2) | ❌ ERROR(2) |
| **ALTA DE REGISTRO POR SUBSANACIÓN DE ERRORES** |
| ⚪️ Operativa Normal | **ALTA DE SUBSANACIÓN** | · Alta para la subsanación de un registro de facturación ya generado/remitido anteriormente.<br>· Es la subsanación habitual de un registro de facturación cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · `<Subsanacion>`=S<br>· No informar `<RechazoPrevio>` o informarlo con valor N | · VERIFACTU<br>· NO VERIFACTU | El registro de facturación debe existir previamente en SIF del obligado / AEAT. | Con él se deja constancia de los nuevos datos que deben ser tenidos en cuenta. | ❌ ERROR(3) | ✅ OK(4) | ✅ OK(5) |
| 🔘 Operativa Especial | **ALTA POR RECHAZO DE SUBSANACIÓN** | · Alta para la subsanación de un registro de facturación que ya está registrado en la AEAT y cuya subsanación posterior fue rechazada.<br>· Es la subsanación de datos cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · `<Subsanacion>`=S<br>· `<RechazoPrevio>`=S | · VERIFACTU | · La clave única del registro de facturación debe existir previamente en la AEAT.<br>· El alta con subsanación del registro de facturación fue rechazada. | Con él se deja constancia de los nuevos datos que deben ser tenidos en cuenta. | ❌ ERROR(3) | ✅ OK(4) | ✅ OK(5) |
| **ALTA DE REGISTRO POR SUBSANACIÓN CUANDO EL REGISTRO ORIGINAL NO EXISTE** |
| 🔘 Operativa Especial | **ALTA DE SUBSANACIÓN SIN REGISTRO PREVIO** | · Alta para la subsanación de un registro de facturación existente en SIF del obligado (a expedir factura) pero que NO existe en la AEAT porque no se remitió en su momento, por ejemplo, porque funcionaba como NO VERIFACTU y cambió a VERIFACTU, que es como funciona ahora; o bien, dependiendo de la implementación del SIF y si así lo necesita, cuando no consta el registro anterior a subsanar en el SIF donde se da de alta la subsanación.<br>· Es la subsanación especial de un registro de facturación cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · `<Subsanacion>`=S<br>· `<RechazoPrevio>`=X | · VERIFACTU<br>· NO VERIFACTU (opcional) | El registro de facturación no debe existir previamente en la AEAT (o bien, en su caso, en SIF del obligado). | Alta del registro de facturación con los nuevos datos | ✅ OK(1) | ❌ ERROR(2) | ❌ ERROR(2) |
| 🔘 Operativa Especial | **ALTA POR RECHAZO DE SUBSANACIÓN SIN REGISTRO PREVIO** | · Alta para la subsanación de un registro de facturación que existe en SIF del obligado (a expedir factura) pero que NO existe en la AEAT porque no se remitió en su momento, por ejemplo, porque el SIF funcionaba como NO VERIFACTU y cambió a VERIFACTU, que es como funciona ahora, y cuya subsanación se rechazó en la AEAT.<br>· Es la subsanación especial de datos cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · `<Subsanacion>`=S<br>· `<RechazoPrevio>`=X | · VERIFACTU | · La clave única del registro de facturación no debe existir previamente en la AEAT. | Alta del registro de facturación con los nuevos datos | ✅ OK(1) | ❌ ERROR(2) | ❌ ERROR(2) |

---

### 7.B) Cuadro Operativa Anulación


| Tipo | Operación | Descripción | Operativa | Tipo SIF al que aplica | Condiciones | Consecuencias | Situación AEAT: No existe registro | Situación AEAT: Existe registro de alta | Situación AEAT: Existe registro de anulación |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **ANULACIÓN DE REGISTRO** |
| ⚪️ Operativa Habitual | **ANULACIÓN** | · Anulación de registro de facturación ya generado/remitido.<br>· Es la anulación habitual de un registro de facturación cuando no se exige la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación). | · No informar `<SinRegistroPrevio>` o informarlo con valor N<br>· No informar `<RechazoPrevio>` o informarlo con valor N | · VERIFACTU<br>· NO VERIFACTU | · El registro de facturación debe existir previamente en SIF del obligado / AEAT.<br>· El registro a anular puede ser de alta o de anulación (en cuyo caso, deja constancia de los nuevos datos a tener en cuenta). | Anula el registro de facturación registrado dejando los nuevos datos. | ❌ ERROR(6) | ✅ OK(7) | ✅ OK(8) |
| 🔘 Operativa Especial | **ANULACIÓN POR RECHAZO** | · Anulación (tras un rechazo previo) del registro de facturación cuando el registro de facturación que se quiere anular está registrado en la AEAT. | · No informar `<SinRegistroPrevio>` o informarlo con valor N<br>· `<RechazoPrevio>`=S | · VERIFACTU | · La clave única del registro de facturación debe existir previamente en la AEAT.<br>· La anulación previa del registro de facturación fue rechazada. | Anula el registro de facturación registrado dejando los nuevos datos. | ❌ ERROR(6) | ✅ OK(7) | ✅ OK(8) |
| **ANULACIÓN DE REGISTRO QUE NO EXISTE PREVIAMENTE** |
| 🔘 Operativa Especial | **ANULACIÓN SIN REGISTRO PREVIO** | ·Anulación del registro de facturación cuando el registro de facturación que se quiere anular existe en SIF del obligado (a expedir factura) pero NO existe en la AEAT porque no se remitió en su momento, por ejemplo, porque funcionaba como NO VERIFACTU y cambió a VERIFACTU, que es como funciona ahora; o bien, dependiendo de la implementación del SIF y si así lo necesita, cuando no consta el registro anterior a anular en el SIF donde se da de alta la anulación. | · `<SinRegistroPrevio>`=S<br>· No informar `<RechazoPrevio>` o informarlo con valor N | · VERIFACTU<br>· NO VERIFACTU (opcional) | ·El registro de facturación no debe existir previamente en la AEAT (o bien, en su caso, en SIF del obligado). | Supone la creación de un registro de facturación de anulación con los nuevos datos. | ✅ OK(9) | ❌ ERROR(10) | ❌ ERROR(10) |
| 🔘 Operativa Especial | **ANULACIÓN POR RECHAZO SIN REGISTRO PREVIO** | · Anulación (tras un rechazo previo) del registro de facturación cuando el registro de facturación que se quiere anular existe en SIF del obligado (a expedir factura) pero NO existe en la AEAT porque no se remitió en su momento, por ejemplo, porque funcionaba como NO VERIFACTU y cambió a VERIFACTU, que es como funciona ahora. | · `<SinRegistroPrevio>`=S<br>· `<RechazoPrevio>`=S | · VERIFACTU | . La clave única del registro de facturación no debe existir previamente en la AEAT.<br>· El intento de anulación anterior del registro de facturación fue rechazado. | Supone la creación de un registro de facturación de anulación con los nuevos datos. | ✅ OK(9) | ❌ ERROR(10) | ❌ ERROR(10) |

---

### LEYENDA

| Símbolo | Significado | Descripción |
| :--- | :--- | :--- |
| ⚪️ | **Operativa Habitual** | Operaciones estándar y comunes. |
| 🔘 | **Operativa Especial** | Operaciones para casos particulares o de corrección de errores. |
| ✅ | **OK** | La operación es admitida por la AEAT. |
| ❌ | **ERROR** | La operación es rechazada por la AEAT. |

**Códigos de Resultado:**
- (1): Se admite el registro de facturación de alta.
- (2): No puede recibirse un registro de facturación de alta de esas características existiendo ya algún registro de facturación de esa factura (bien sea de alta o de anulación).
- (3): Debería existir ya un registro de facturación para esa factura. Si esta situación de error se produce debido a una secuencia de envío incorrecta, se deberá volver a remitir, sin más, una vez haya entrado -por la vía que sea- el registro de facturación.
- (4): El registro remitido sustituye completamente al registro de facturación con los nuevos datos recibidos.
- (5): Reactiva (vuelve a dejar de alta y en vigor) el registro de facturación anulado existente, sustituyendo completamente el registro de facturación registrado con los nuevos datos recibidos.
- (6): Debería existir en la AEAT un registro de facturación previo correspondiente a esa factura.
- (7): El registro remitido anula el registro de facturación de alta registrado dejando los nuevos datos recibidos.
- (8): El registro remitido anula el registro de facturación de anulación registrado dejando los nuevos datos recibidos.
- (9): Creación del registro de facturación de anulación con los datos recibidos.
- (10): En una "ANULACIÓN SIN REGISTRO PREVIO" NO puede haber en la AEAT ningún registro de facturación de esa factura ya remitido (bien sea de alta o de anulación).

---
---

# ACLARACIONES DUDAS DESARROLLADORES (SÓLO TÉCNICO)

## 3. CONSIDERACIÓN SOBRE FABRICACIÓN Y COMERCIALIZACIÓN DE UN ÚNICO PRODUCTO SIF VS. UN "CONJUNTO, PAQUETE O FAMILIA" DE PRODUCTOS SIF.

Productor con sistema adaptable a RRSIF/sin adaptar o para varias normativas (TicketBAI, RD 1007/2023, SII), ofrece "paquete/familia" de productos SIF distintos.

La implementación debe impedir el cambio dinámico de producto por factura, sesión o arranque. El usuario elige SIF, instala/actualiza y las características permanecen.

La declaración responsable del productor/fabricante solo para SIF instalado que cumpla RD 1007/2023.

Aplica a SIF en nube (SaaS): no un único SIF para cumplir/no RD 1007/2023. Deben ser varios SIF; usuario elige el aplicable a su facturación.

### NOTA ACLARATORIA:

NO es posible el uso dinámico del SIF (cambio por sesión, arranque o factura). Se evita el cumplimiento intermitente/voluntario.

No impide cambios normativos aceptados (ej. RD 1007/2023 a SII) con plazos/condiciones. El sistema debe asegurar dichas condiciones, impedir cambios "dinámicos" y garantizar el marco normativo.

"A menos que se desinstale" significa "cambio permanente". Cambiar la implementación de facturación es cambiar de SIF. Ej: un SIF RD 1007/2023 que cambia a SII es un nuevo SIF con otra identificación.

## 4. CÓMO IDENTIFICAR UN SIF. QUÉ SE CONSIDERA SIF Y NÚMERO DE INSTALACIÓN, Y CÓMO IDENTIFICARLOS. SIF QUE GESTIONAN MÁS DE UNA FACTURACIÓN.

SIF expide facturas con QR y simultáneamente genera/remite/conserva sus RF.

Identificación universal SIF: **Id.OEF (NIF) + Id.SIF (código 2 pos. fabricante) + NoInstalacion**.

**Nº de instalación**: unívoco por SIF de un OEF, siempre. No se repite. Reinstalación de software requiere nuevo nº de instalación.

Nº de instalación recomendado:
- **"Timestamp"** (mín. fecha+hora+min+seg) de la instalación.
- **Nº secuencial** (autonumérico) no repetido para ese OEF: 1, 2, 3... n.

SIF con distintas facturaciones (diferentes OEF/centros de facturación): cada facturación es un SIF independiente con nº de instalación propio.

En SIF SaaS, **'IndicadorMultiplesOT'** ('SistemaInformatico') se calcula por usuario. **"S"** si el usuario tiene >1 facturación; si no, **"N"**.

## 5. ARQUITECTURAS DE LOS SIF.

Se permiten arquitecturas "mixtas" con varios componentes/fabricantes. Ej: TPVs conectados en tiempo real a backoffice centralizado.

**I.- PARA LA MODALIDAD VERIFACTU:**
Es admitido que:
a) Datos TPV se consoliden en backoffice, que genera y devuelve "Registro de alta de factura". TPV imprime factura con QR.
b) Tras imprimir, TPV notifica a backoffice para envío inmediato del registro a AEAT.

Alternativa: TPV genera "Registro de alta de factura", imprime con QR y pasa a backoffice para remisión a AEAT.

**II.- REQUISITOS GENERALES PARA ARQUITECTURAS MIXTAS:**
- Todos los componentes de facturación deben estar certificados.
- No alterar el registro de facturación en sistemas ni en transmisión.
- Conexión entre sistemas indefectible y automática, no a decisión del usuario. No puede haber facturas sin RF, ni RF sin remitir (VERIFACTU).
- RF íntegramente producido al generar factura y QR, o de forma simultánea/inmediata.
- En NO VERIFACTU, respetar firma del sistema emisor. No disociar autoría de expedir y generar/firmar RF.
- SIF con varios componentes (especialmente distintos fabricantes) deben tener Certificación por Declaración Responsable (DR). Cada fabricante es responsable de su componente.
- En DR del componente principal (CPF) indicar qué componentes de facturación (CF) de terceros invoca, su versión y uso.
- Componentes del mismo fabricante con ciclos evolutivos independientes se tratan como de terceros.
- Componentes del mismo fabricante con ciclos evolutivos vinculados: puede bastar una DR para el CPF, explicando integración y uso indefectible de CF. Cambio en CF implica cambio de versión del CPF.
- Certificado electrónico cualificado para firmar/remitir RF debe ser admitido y tener facultades necesarias.

## 6. PROHIBICIÓN DE NUMERACIÓN DUPLICADA DE UN REGISTRO

VERIFACTU no acepta reutilizar números de factura. Enviar un nuevo registro con el nº de uno anulado devuelve error "Registro de facturación duplicado."

Identificador RF: (Emisor+SerieYNúmeroFactura+FechaExped.). Reutilizar numeración (incluso de prueba) duplica el identificador y causa rechazo.

No es posible reutilizar la numeración de facturas expedidas. Las facturas "de prueba" son reales y, si no son una operación real, deben anularse con su registro de anulación.

## 7. SIF PARA MÚLTIPLES USUARIOS: VISUALIZACIÓN DE USUARIOS.

SIF debe visualizar siempre y claramente la info. identificativa del obligado tributario (nombre/razón social, NIF, o ambos).

Si SIF soporta >1 obligado tributario, debe indicarlo con un mensaje explicativo de consulta rápida y fácil.

## 8. SIF ÚNICO COMPUESTO DE FUNCIONALIDAD DE INTRODUCCION + SERVICIO DE ENVÍO. FORMA DE HACER LA CERTIFICACIÓN.

Certificación si varios productos usan un servicio de envío común (misma empresa):

1.  Servicio invocado indefectiblemente: es parte indisociable. No requiere DR propia, pero la DR de cada producto debe mencionarlo. Un cambio en el servicio = cambio de versión en los productos.
2.  Servicio independiente: debe certificarse por separado. La DR de cada producto debe mencionar su uso y la versión. Un cambio en el servicio solo afecta a la versión del servicio.

El control de versión es por producto certificado.

## 9. PERSONALIZACIÓN DE SOFTWARE.

Personalizaciones que NO alteran requisitos del RD 1007/2023 no son "componentes de facturación". No necesitan DR ni control de versiones propios; vale la del producto estándar.

Si la personalización afecta/cambia la implementación de requisitos, es una alteración de un componente de facturación y requiere DR propia.

No se aceptan personalizaciones que permitan eludir la normativa. Ej: usuario puede ubicar el QR, pero no emitir facturas sin él.

## 10. IMPORTACION DE FACTURAS DESDE OTRO SISTEMA.

La responsabilidad del fabricante SIF cubre los RF de facturas emitidas por su SIF certificado, no los de otros.

Facturas importadas por delegación (autofacturas/tercero) ya han sido procesadas por el SIF emisor. No reimprimir con QR ni reenviar a la AEAT.

Para diferenciar, las facturas importadas deben incluir sus RF. La identidad del SIF emisor en el RF las identifica como importadas.

## 11. BORRADORES DE FACTURA, "PRE-FACTURAS", FACTURAS PROFORMA, ALBARANES, FACTURAS DE PRUEBA...

Borradores, proformas o facturas sin validez fiscal son una operación previa a generar el RF definitivo.

Registros de albaranes, proformas, etc. sin validez fiscal, una vez expedidos, deben conservarse inalterables.

**Facturas de prueba/formación** en un SIF operativo son tratadas como reales. Un SIF en producción no puede generar "facturas ficticias".

Para pruebas, el usuario expide facturas "reales" (con QR y RF de alta remitido a AEAT). Al no ser operaciones reales, deben ser **inmediatamente anuladas** con su RF de anulación.

SIF puede ofrecer "facturar en pruebas" que automatice:
1.  Permitir expedir facturas (ej. serie "PRU").
2.  Describirlas visiblemente como "de pruebas".
3.  Asegurar su anulación (con remisión del RF de anulación) al finalizar las pruebas.

## 12. MAQUINAS DE VENDING Y RRSIF

Máquinas de vending obligadas a emitir facturas simplificadas también deben cumplir el RRSIF.

Tras vigor de la normativa, sus justificantes deben ser como una factura simplificada:
- Producir un registro XML.
- Generar un hash encadenado con la factura anterior.
- Imprimir factura/justificante con QR.
- Conservar todo firmado e inalterado (NO VERIFACTU) o remitirlo a la sede electrónica (VERIFACTU).

## 13. CONSERVACIÓN DE REGISTROS EN VERIFACTU Y LIBROS REGISTROS

En VERIFACTU, la obligación de conservar RF **NO** está regulada para el desarrollador/usuario; los conserva la AEAT.

Por funcionalidad (no obligación), es lógico que los sistemas conserven los RF. Las facturas completas deben conservarse si el RF no tiene todo el detalle (ej. líneas de facturación).

## 15. CHEQUEO AUTOMÁTICO DEL CORRECTO ENCADENAMIENTO. COMPROBACIONES AUTOMÁTICAS A REALIZAR POR LOS SIF

Salvo para el primer registro, al generar un nuevo RF, el SIF debe comprobar:

1.  **Correcto encadenamiento del último RF.** Verificar que "Huella" en "Encadenamiento" -> "RegistroAnterior" de RF n-1 coincide con "Huella" de RF n-2.
2.  **Fecha/hora del último registro no es >1 min superior a la actual.** Impide generar un RF con fecha/hora anterior a la del último (margen 1 min). No importa si pasó >1 min desde la última factura.

SIF **NO VERIFACTU** que detecta error de encadenamiento: debe guardar un evento y advertir visualmente. **La facturación NUNCA debe interrumpirse**; permitir generar el siguiente RF.

La comprobación del encadenamiento debe ser instantánea y no impactar en el tiempo de venta.

SIF **NO VERIFACTU** debe tener un Registro de Eventos y funciones para comprobar anomalías, disponibles para el usuario. La comprobación del encadenamiento previa a generar un nuevo RF es siempre obligatoria.

Un SIF solo **VERIFACTU** no está obligado a tener registro de eventos. Un SIF **DUAL** debe implementarlo y activarlo en modo NO VERIFACTU.

## 16. REPRESENTACIÓN DE LOS OBLIGADOS A EMITIR FACTURAS (OEF) POR PARTE DE LAS EMPRESAS DE SOFTWARE.

Una empresa de software necesita autorización para remitir RF en nombre de sus clientes.

Se pueden usar medios electrónicos eficientes (formularios web, pop-ups) que aseguren el apoderamiento. El uso del API de remisión solo tras otorgar y aceptar la representación. Los sistemas deben exigir cumplimentación y firma (también electrónica).

## 17. FORMA DE PROCEDER ANTE ERRORES COMETIDOS AL FACTURAR: RECTIFICACIONES, ANULACIONES, SUBSANACIONES.

Operativa SIF ante errores:

**1.- ANTES DE EXPEDIR FACTURA:**
Corregir errores en la fase de edición.

**2.- DESPUÉS DE EXPEDIR FACTURA:**
a) **Errores ROF:** Expedir factura/s rectificativa/s según ROF. Generar un **RF de alta** por cada una.

b) **Errores en campos RF (no ROF):** Si el error afecta a campos internos del RF y no requiere rectificativa ROF, corregir factura original y generar un **RF de alta de subsanación**.
   - Si RF original **rechazado** por AEAT, RF de subsanación con 'Subsanacion'="S" y 'RechazoPrevio'="X".
   - Si RF original **aceptado**, RF de subsanación normal.

c) **Errores no ROF ni RF:** Corregir factura original sin generar nuevo RF.

d) **Factura incorrecta/no debió emitirse:** Si el ROF no indica otro procedimiento, anular la factura con un **RF de anulación** (ej. servicio no realizado).

La anulación "deshace" la factura, sin efectos fiscales. Conservar/remitir el registro original y el de anulación. El uso de RF de anulación y subsanación debe ser excepcional.

## 19. RAPPELS Y RECTIFICACIÓN.

Facturas de rappels (descuentos por volumen) son facturas rectificativas.

Según art. 15.4 ROF, en la rectificativa por rappels no es necesario identificar todas las facturas, basta con indicar el período.

## 20. CONCEPTO "IMPORTE TOTAL" EN EL REGISTRO DE FACTURACIÓN

`ImporteTotal` se calcula:
**`ImporteTotal` = Σ (BaseImponibleOimporteNoSujeto + CuotaRepercutida + CuotaRecargoEquivalencia)** de todas las líneas.

Retenciones (IRPF, IS), suplidos, recargos financieros, etc., **NO forman parte del `ImporteTotal`** para el RF. Alteran el "total a pagar", no el "Importe total factura" fiscal.

El SIF puede imprimir ambos importes diferenciados: "Importe total factura" (para QR) y "Total a pagar".

## 21. EQUIVALENCIA CLAVE L13 CAUSA DE NO SUJECIÓN EN TICKETBAI

Equivalencias claves no sujeción TicketBAI en VERIFACTU:
- **"OT"** (TicketBAI) -> **"N1"** (VERIFACTU).
- **"RL"** e **"IE"** (TicketBAI) -> **"N2"** (VERIFACTU).
- **"VT"** (TicketBAI) **NO** tiene correspondencia. Suplidos no se reflejan en RF de VERIFACTU ni suman al `ImporteTotal`.

## 22. ¿CÓMO SE REFLEJA LA VENTA DE UN BOLETO DE LOTERÍA EN UN REGISTRO DE FACTURACIÓN?

Venta de lotería por valor facial es operación exenta, generalmente no obliga a facturar.

Si se incluye en una factura, constará como entrega exenta con causa **E1**. En la línea, solo rellenar base imponible.

Alternativa: considerarlo suplido. El importe **NO formaría parte del RF de alta** y solo alteraría el "total a pagar".

## 23. DESGLOSE DEL REGISTRO DE FACTURACIÓN DE ALTA CUANDO SE TRATA DE ENTREGAS DE BIENES O PRESTACIONES DE SERVICIOS LOCALIZADAS EN CANARIAS

**1. Empresa IVA vende desde establecimiento en Canarias (factura sujeta a IGIC):**
- Impuesto: `03` (IGIC)
- Clave de régimen: `01` (u otra L8B)
- Calificación operación: `S1`
- Tipo: el de IGIC
- BI y Cuota: las correspondientes.

**2. Empresa peninsular presta servicio localizado en Canarias (sujeto a IGIC):**
Operación no sujeta a IVA.
- Impuesto: `01` (IVA)
- Clave de régimen: `08`
- Calificación operación: `N2`
- Tipo: blanco
- BI: la correspondiente
- Cuota: blanco

## 24. EL CRITERIO DE CAJA Y VERIFACTU

**1. Emisor peninsular criterio caja (ClaveRegimen=`07`) factura servicio a Canarias:**
Operación fuera TAI, excluida de criterio de caja.
- Impuesto: `01`
- Clave de régimen: `08`
- Calificación operación: `N2`

**2. Emisor canario criterio caja factura servicio a península:**
Operación en TAI con inversión sujeto pasivo, excluida de criterio de caja.
- Impuesto: `03`
- Clave de régimen: `08`
- Calificación operación: `N2`

**3. Emisor criterio caja factura servicio fuera UE:**
Operación fuera TAI, excluida de criterio de caja.
- Impuesto: `01`
- Clave de régimen: `01`
- Calificación operación: `N2`

**4. Emisor criterio caja factura servicio a cliente UE con VIES:**
Operación fuera TAI, excluida de criterio de caja.
- Id type: `02`
- Id: NIVA destinatario
- Impuesto: `01`
- Clave de régimen: `01`
- Calificación operación: `N2`

## 25. LA LISTA L10 (CAUSAS DE EXENCIÓN) DEL SII-IGIC

Causas de exención IGIC 'E6 - Zona Especial Canaria', 'E7 - REPEP' y 'E8 - Exenta otros' corresponden a **'E6 - Exenta por otros'** de la lista L10 VERIFACTU.

## 26. CONTENIDO DE LA FACTURA: IVA, IGIC O IPSI

Una factura puede incluir operaciones con distintos impuestos (IVA, IGIC, IPSI) por reglas de localización.

`Impuesto` (lista L1) se indica por operación.
- `Impuesto`="01" (IVA) -> `ClaveRegimen` de lista L8A.
- `Impuesto`="03" (IGIC) -> `ClaveRegimen` de lista L8B.
- `Impuesto`="02" (IPSI) -> `ClaveRegimen` **no se rellena**.

## 27. FACTURAS EXPEDIDAS EN SUSTITUCIÓN DE FACTURAS SIMPLIFICADAS

**1. Si F2 (simplificada), ya en F3 (sustitutiva), es incorrecta:**
Rectificar F2 (generando R5). Luego, emitir **nueva F3** que sustituya a R5 para corregir el IVA soportado del destinatario.

**2. Si F2 están correctas pero F3 no:**
Emitir una nueva F3 rectificativa por la diferencia.

## 29. CLAVES 14 Y 15 IVA PENDIENTE DE DEVENGO

**1. Retraso pago factura clave 15:**
No hacer nada en SIF. Sin nueva factura ni modificación de devengo.

**2. Pago anticipado factura clave 15:**
- Generar nueva factura (y RF de alta) por el anticipo.
- Modificar factura inicial para ajustar BI y cuota (a cero si el anticipo es total).

---
---

# VALIDACIONES EN VERIFACTU

## 1. OBJETIVO

   El presente documento constituye el resultado de la fase de análisis de validaciones y gestión de errores del proyecto de Sistemas Informáticos de Facturación y Sistemas VERIFACTU regulado por el Reglamento aprobado por el Real Decreto 1007/2023, de 5 de diciembre, y su correspondiente orden ministerial.

   En el proceso de recepción de los mensajes con registros de alta y anulación, la AEAT realiza automáticamente una serie de validaciones. En este documento se detallan dichas validaciones.
   

## 3. VALIDACIONES

   1. Validaciones

      Se han definido tres tipologías de validaciones:

      1. Validaciones estructurales: para validar que la estructura de etiquetas cumple el esquema en cuanto al establecimiento de etiquetas obligatorias.

         El no cumplimiento de estas validaciones dará lugar al rechazo completo del mensaje de remisión.
      2. Validaciones  sintácticas: en ellas se valida el formato, longitud, obligatoriedad del contenido y si el valor debe coincidir con una serie de valores preestablecidos, en los casos que aplique.

         Cuando estos errores se hayan producido en el bloque Cabecera, darán lugar al rechazo completo del mensaje de remisión.

         Cuando estos errores se hayan producido a nivel de registro (agrupaciones RegistroAlta o RegistroAnulacion dentro del bloque RegistroFactura), provocarán el rechazo del registro, pero se seguirán procesando el resto de registros incluidos en el mensaje de remisión.
      3. Validaciones de negocio: estarán asociadas principalmente a validaciones de campos cuyo contenido u obligatoriedad depende del valor asociado a otro campo.

      Estos errores provocarán el rechazo del registro, pero se seguirán procesando el resto de registros en el mensaje de remisión.

      1. Validaciones de negocio del bloque Cabecera.

         1. ObligadoEmision

            * El NIF del obligado a expedir (emitir) facturas asociado a la remisión debe estar identificado en la AEAT.
         2. Representante

            * El NIF del representante/asesor del obligado a expedir (emitir) facturas asociado a la remisión debe estar identificado en la AEAT.
         3. FechaFinVeriFactu

            * Sólo se permite contenido en sistemas que emite facturas verificables.
            * La fecha debe tener el formato 31-12-20XX.
            * El año de la fecha deberá ser igual al año de la fecha del sistema de la AEAT, o al año anterior (para admitir casos excepcionales y puntuales que pudieran darse a finales de un año y comienzo del siguiente).
         4. Incidencia

            * Sólo se permite contenido en sistemas que emite facturas verificables.
         5. RefRequerimiento

            * Sólo se permite contenido en sistemas que emiten facturas no verificables.
            * Obligatorio en sistemas que emiten facturas no verificables.
            * La referencia del requerimiento deberá existir en la AEAT.
      2. Validaciones de negocio del bloque RegistroFactura.

         1. Agrupaciones RegistroAlta y RegistroAnulacion

            * Dentro de cada una de las posibles repeticiones u “ocurrencias” de RegistroFactura (de 1 a 1000) se pueden incluir registros de facturación de alta (agrupación RegistroAlta) y de anulación (agrupación RegistroAnulacion) en un mismo mensaje remitido, pero siempre que vayan en distintas ocurrencias de RegistroFactura (no pueden ir ambas agrupaciones a la vez dentro de la misma ocurrencia).
      3. Validaciones de negocio de la agrupación RegistroAlta en el bloque de RegistroFactura.

         1. Agrupación IDFactura

            * El NIF del campo IDEmisorFactura debe ser el mismo que el del campo NIF de la agrupación ObligadoEmision del bloque Cabecera.
            * La FechaExpedicionFactura no podrá ser superior a la fecha actual.
            * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), la FechaExpedicionFactura solo puede ser anterior a la FechaOperacion, si ClaveRegimen= "14" o "15”.
            * La FechaExpedicionFactura no debe ser inferior a 28/10/2024 (fecha de entrada en vigor de la Orden Ministerial de VERIFACTU).
            * NumSerieFactura solo puede contener caracteres ASCII del 32 a 126 (caracteres imprimibles)
         2. RechazoPrevio

            * Solo podrá incluirse el campo RechazoPrevio con valor “X” si se ha informado el campo Subsanacion y tiene el valor “S”.
            * No podrá informarse el campo RechazoPrevio con valor “S” si no se informa el campo Subsanación o éste tiene el valor “N”
         3. TipoRectificativa

            * Solo podrá incluirse este campo si el valor del campo TipoFactura es igual a “R1”, “R2”, “R3”, “R4” o “R5”
            * Campo obligatorio si TipoFactura es igual a “R1”, “R2”, “R3”, “R4” o “R5”.
         4. Agrupación FacturasRectificadas

            * El NIF del campo IDEmisorFactura debe estar identificado.
            * Sólo podrá incluirse esta agrupación (no es obligatoria) si TipoFactura es igual a “R1”, “R2”, “R3”, “R4” o “R5”.
         5. Agrupación FacturasSustituidas

            * El NIF del campo IDEmisorFactura debe estar identificado.
            * Sólo podrá incluirse esta agrupación (no es obligatoria) cuando el campo TipoFactura="F3".
         6. Agrupación ImporteRectificacion

            * Sólo deberá incluirse esta agrupación si el campo TipoRectificativa = "S".
            * Obligatorio si TipoRectificativa = “S”.
         7. FechaOperacion

            * La FechaOperacion no debe ser inferior a la fecha actual menos veinte años y no debe ser superior al año siguiente de la fecha actual.
            * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), el campo FechaOperacion solo podrá ser superior a la fecha actual, si ClaveRegimen= "14" o "15”.
         8. FacturaSimplificadaArt7273

            * Sólo se podrá rellenar con “S” si TipoFactura=“F1” o “F3” o “R1” o “R2” o “R3” o “R4”.
         9. FacturaSinIdentifDestinatarioArt61d

            * Sólo se podrá rellenar con “S” si TipoFactura=”F2” o “R5”.
         10. Macrodato

             * Campo obligatorio si ImporteTotal >= |100.000.000,00| (valor absoluto).
         11. EmitidaPorTerceroODestinatario

             * Si es igual a “T”, el bloque Tercero será de cumplimentación obligatoria.
             * Si es igual a “D”, el bloque Destinatarios será de cumplimentación obligatoria.
         12. Agrupación Tercero

             * Solo podrá cumplimentarse si EmitidaPorTerceroODestinatario es “T”.
             * Si se identifica mediante NIF, el NIF debe estar identificado y ser distinto del NIF del campo IDEmisorFactura de la agrupación IDFactura.
             * Si se cumplimenta NIF, no deberá existir la agrupación IDOtro y viceversa, pero es obligatorio que se cumplimente uno de los dos.
             * Si el campo IDType = “02” (NIF-IVA), no será exigible el campo CodigoPais.
             * Cuando el tercero se identifique a través de la agrupación IDOtro e IDType sea “02”, se validará que el campo identificador ID se ajuste a la estructura de NIF-IVA de alguno de los Estados Miembros y debe estar identificado. Ver nota (1).
             * Si se identifica a través de la agrupación IDOtro y CodigoPais sea "ES", se validará que el campo IDType sea “03”.
             * No se admite el tipo de identificación IDType “07” (No censado).
         13. Agrupación Destinatarios

             * Si TipoFactura es “F1”, “F3”, “R1”, “R2”, “R3” o “R4”, la agrupación Destinatarios tiene que estar cumplimentada, con al menos un destinatario.
             * Si TipoFactura es “F2” o “R5”, la agrupación Destinatarios no puede estar cumplimentada.
             * Si se cumplimenta NIF, no deberá existir la agrupación IDOtro y viceversa, pero es obligatorio que se cumplimente uno de los dos.
             * Si el campo IDType = “02” (NIF-IVA), no será exigible el campo CodigoPais.
             * Si el campo IDType = “07” (No censado), el campo CodigoPais debe ser “ES”.
             * Cuando uno o varios destinatarios se identifiquen a través de la agrupación IDOtro e IDType sea “02”, se validará que el campo identificador se ajuste a la estructura de NIF-IVA de alguno de los Estados Miembros y debe estar identificado. Ver nota (1).
             * Cuando uno o varios destinatarios se identifiquen a través de la agrupación IDOtro y CodigoPais sea "ES", se validará que el campo IDType sea “03” o “07”.
             * Cuando se identifique a través del bloque “IDOtro” y IDType sea “02”, se validará que TipoFactura sea “F1”, “F3”, “R1”, “R2”, “R3” ó “R4”.
         14. Cupon

             * Sólo se podrá rellenar con “S” (no es obligatorio) si TipoFactura = ”R5” o “R1”
         15. Agrupación Desglose / DetalleDesglose.

             1. TipoImpositivo

                * Si Impuesto = “01” (IVA) o no se cumplimenta (considerándose “01” - IVA) y CalificacionOperacion = “S1”:

                  + Solo se permiten TipoImpositivo = 0; 2; 4; 5; 7,5; 10 y 21 (valores que indican el tanto por ciento).
                  + Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) ≥ 1 de julio de 2022 y ≤ 30 de septiembre de 2024 se admitirá TipoImpositivo = 5.
                  + Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) ≥ 1 de octubre de 2024 y ≤ 31 de diciembre de 2024 se admitirá el TipoImpositivo = 2
                  + Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) ≥ 1 de octubre de 2024 y ≤ 31 de diciembre de 2024 se admitirá el TipoImpositivo = 7,5.
             2. BaseImponibleACoste

                * El campo BaseImponibleACoste solo puede estar cumplimentado si la ClaveRegimen es = “06” o Impuesto = “02” (IPSI) o Impuesto = “05” (Otros).
             3. TipoRecargoEquivalencia

                * Si Impuesto = “01” (IVA) o no se cumplimenta (considerándose “01” - IVA) y CalificacionOperacion = “S1”:

                  + Solo se permiten TipoRecargoEquivalencia = 0; 0,26; 0,5; 0,62; 1; 1,4; 1,75; 5,2 (valores que indican el tanto por ciento).
                  + Si TipoImpositivo es 21 sólo se admitirán TipoRecargoEquivalencia = 5,2 ó 1,75.
                  + Si TipoImpositivo es 10 sólo se admitirá TipoRecargoEquivalencia = 1,4.
                  + Si TipoImpositivo es 7,5 sólo se admitirá TipoRecargoEquivalencia = 1.

                    - Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) es mayor o igual que 1 de octubre de 2024 y menor o igual que 31 de diciembre de 2024 se admitirá el TipoRecargoEquivalencia = 1.
                  + Si tipo impositivo es 5:

                    - Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) es igual o inferior al 31 de diciembre de 2022, solo se admitirá TipoRecargoEquivalencia = 0,5.
                    - Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) es mayor o igual que 1 de enero de 2023 y menor o igual que 30 de septiembre de 2024, solo se admitirá TipoRecargoEquivalencia = 0,62.
                  + Si TipoImpositivo es 4 sólo se admitirá TipoRecargoEquivalencia = 0,5.
                  + Si TipoImpositivo es 2 sólo se admitirá TipoRecargoEquivalencia = 0,26.

                    - Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) es mayor o igual que 1 de octubre de 2024 y menor o igual que 31 de diciembre de 2024 se admitirá el TipoRecargoEquivalencia = 0,26.
                  + Si tipo impositivo es 0:

                    - Si FechaOperacion (FechaExpedicionFactura de la agrupación IDFactura si no se informa FechaOperacion) es mayor o igual que 1 de enero de 2023 y menor o igual que 30 de septiembre de 2024, solo se admitirá TipoRecargoEquivalencia = 0.
             4. CalificacionOperacion

                * Si CalificacionOperacion es “S2”, TipoFactura solo puede ser “F1”, “F3”, “R1”, “R2”, “R3” y “R4”.
                * Cuando CalificacionOperacion sea “S2”:

                  + TipoImpositivo = 0. (No se admite que vaya vacío o que el campo no exista).
                  + CuotaRepercutida = 0. (No se admite que vaya vacío o que el campo no exista ).
                * Si CalificacionOperacion es = “N1/N2” e Impuesto = ”01” (IVA) o no se cumplimenta (considerándose “01” - IVA), no se puede informar ninguno de estos campos:
                * TipoImpositivo, CuotaRepercutida.
                * TipoRecargoEquivalencia, CuotaRecargoEquivalencia.
             5. OperacionExenta.

                * Si Impuesto = “01” (IVA) o no se cumplimenta (considerándose “01” - IVA), el valor de OperacionExenta deberá estar contenido en lista L10.
                * Si Impuesto = “03” (IGIC), el valor de OperacionExenta deberá estar contenido en lista L10 y adicionalmente podrá contener los valores “E7” y “E8”.
                * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), y ClaveRegimen es igual a “01”, no pueden marcarse los valores de OperacionExenta “E2” y “E3”.
                * Si el campo OperacionExenta está cumplimentado no se pueden informar ninguno de estos campos: TipoImpositivo, CuotaRepercutida, TipoRecargoEquivalencia y CuotaRecargoEquivalencia.
             6. ClaveRegimen

                * Solo podrá incluirse este campo si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA) y será obligatorio.
                * Si Impuesto = “01” (IVA) o no se cumplimenta (considerándose “01” - IVA), el valor de ClaveRegimen deberá estar cumplimentado y contenido en lista L8A.
                * Si Impuesto = “03” (IGIC), el valor de ClaveRegimen deberá estar cumplimentado y contenido en lista L8B. Adicionalmente, puede contener el valor “20” (Operaciones sujetas al IPSI).
                1. ClaveRegimen 02. Exportación.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), si clave de ClaveRegimen es igual a “02”, solo puede estar cumplimentado OperacionExenta.
                2. ClaveRegimen 03. REBU.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), cuando ClaveRegimen sea igual a “03”, si se cumplimenta CalificacionOperacion, este campo solo puede contener el valor “S1”.

                     Aclaración: ClaveRegimen “03” es compatible con operación exenta, ya que el artículo 137. Dos. 5ª de la Ley 37/1992, de 28 de diciembre, del Impuesto sobre el Valor Añadido contempla expresamente la posibilidad de aplicar exenciones en REBU (Régimen especial de bienes usados, objetos de arte, antigüedades y objetos de colección).
                3. ClaveRegimen 04. Operaciones con oro de inversión.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA), si clave de ClaveRegimen es igual a “04”, CalificacionOperacion solo puede ser “S2”, o bien OperacionExenta.
                4. ClaveRegimen 06. Grupo de entidades nivel avanzado.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA):

                     + Si ClaveRegimen es igual a “06”:

                       - Se validará que TipoFactura sea distinto de “F2”, “F3”, “R5”.
                       - Campo BaseImponibleACoste deberá estar cumplimentado.
                5. ClaveRegimen 07. Criterio de caja.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA):

                     + Si ClaveRegimen = “07”:

                       - CalificacionOperacion no puede ser “S2”, “N1”, “N2”.
                       - OperacionExenta no puede ser “E2”, “E3”, “E4” y “E5”.
                6. ClaveRegimen 08.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA):

                     + Si ClaveRegimen = “08”, CalificacionOperacion tiene que ser “N2” y siempre debe ir relleno.
                7. ClaveRegimen 10. Cobro por cuenta de terceros.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA):

                     + Si existe una ClaveRegimen “10”:

                       - CalificacionOperacion tiene que ser “N1” y siempre debe ir relleno.
                       - TipoFactura tiene que ser “F1”.
                       - Todos los destinatarios tienen que estar identificado mediante NIF.
                8. ClaveRegimen 11. Arrendamiento de local de negocio

                   * Si Impuesto = “01” (IVA) o no se cumplimenta (considerándose “01” - IVA), cuando ClaveRegimen sea “11”, únicamente se admitirá el TipoImpositivo = 21.
                9. ClaveRegimen 14. IVA pendiente AAPP.

                   * Si Impuesto = “01” (IVA), “03” (IGIC) o no se cumplimenta (considerándose “01” - IVA):

                     + Si existe una ClaveRegimen igual a “14”:

                       - FechaOperacion, campo de cumplimentación obligatoria y posterior a fecha de expedición.
                       - Todos los destinatarios tienen que estar identificados mediante NIF y comenzar por “P”,”Q”,”S” o “V”.
                       - TipoFactura: se validará que tipo de factura sea “F1”, “R1”, “R2”, “R3” o “R4”.
                10. ClaveRegimen 20 (IGIC). Operaciones sujetas al IPSI.

                    * Si Impuesto = “03” (IGIC), el valor de ClaveRegimen debe estar contenido en la lista L8B y adicionalmente puede contener el valor “20” (Operaciones sujetas al IPSI).
                11. ClaveRegimen 21 (IGIC). Régimen simplificado.

                    * Si Impuesto = “03” (IGIC), el valor de ClaveRegimen debe estar contenido en la lista L8B y adicionalmente puede contener el valor “21” (Régimen simplificado).
             7. CuotaRepercutida.

                * Solo podrá ser distinta de cero (positivo o negativo) si CalificacionOperacion es “S1”.
                * Si CalificacionOperacion es “S1” y BaseImponibleACoste no está cumplimentada, se validará que:

                  + TipoImpositivo: campo obligatorio.
                  + CuotaRepercutida: campo obligatorio y deberá validarse (excepto si TipoRectificativa

                    = “I” o TipoFactura “R2”, “R3”) que:

                    - CuotaRepercutida y BaseImponibleOimporteNoSujeto deben tener el mismo signo.
                    - [CuotaRepercutida] = ([BaseImponibleOimporteNoSujeto] \* TipoImpositivo)

                      / 100 +/- 10,00 euros
                * Si CalificacionOperacion es “S1” y BaseImponibleACoste está cumplimentada, se validará que:

                  + TipoImpositivo: campo obligatorio.
                  + CuotaRepercutida: campo obligatorio y deberá validarse (excepto si TipoRectificativa

                    = “I” o TipoFactura “R2”, “R3”) que:

                    - CuotaRepercutida y BaseImponibleACoste deben tener el mismo signo.
                    - [CuotaRepercutida] = ([BaseImponibleACoste] \* TipoImpositivo) / 100 +/- 10,00 euros.
             8. Validaciones adicionales en el caso de facturas simplificadas.

                - Cuando TipoFactura sea “F2”, se validará que Ʃ (BaseImponibleOimporteNoSujeto + CuotaRepercutida) de todas las líneas de detalle no sea superior a 3.000,00 euros. Se admitirá un error de + 10,00 euros.

                Esta validación no se aplicará cuando exista acuerdo de facturación, es decir, cuando el campo NumRegistroAcuerdoFacturacion esté cumplimentado. Esta validación tampoco se aplicará cuando el campo FacturaSinIdentifDestinatarioArticulo61d = “S”.
         16. CuotaTotal

             - Se validará que sea igual a Ʃ (CuotaRepercutida + CuotaRecargoEquivalencia) de todas las líneas de detalle de desglose. En caso contrario se devolverá un aviso de error (no generará rechazo), admitiéndose un margen de error de +/- 10,00 euros.
         17. ImporteTotal

             * Se validará que sea igual a Ʃ (BaseImponibleOimporteNoSujeto + CuotaRepercutida + CuotaRecargoEquivalencia) de todas las líneas de detalle de desglose. En caso contrario se devolverá un aviso de error (no generará rechazo), admitiéndose un margen de error de +/- 10,00 euros.
             * Esta validación no se aplicará cuando ClaveRegimen sea “03”, “05”, “06”, “08” o “09”.
         18. Huella (del registro anterior)

             - Se validará que la huella del encadenamiento del registro anterior cumpla el formato de salida del algoritmo SHA-256, siendo de 64 caracteres en hexadecimal y en mayúsculas. En caso contrario se devolverá un aviso de error (no generará rechazo).
         19. Agrupación SistemaInformatico

             Ver las validaciones que le aplican en su apartado correspondiente.
         20. FechaHoraHusoGenRegistro

             Se validará que la FechaHoraHusoGenRegistro sea menor o igual que la fecha del sistema de la AEAT, admitiéndose un margen de error. En caso de superar el umbral, se devolverá un aviso de error (no generará rechazo).
         21. NumRegistroAcuerdoFacturacion

             - Si se informa, debe existir el NumRegistroAcuerdoFacturacion en la AEAT.
         22. IdAcuerdoSistemaInformatico

             - Si se informa, debe existir el IdAcuerdoSistemaInformatico en la AEAT.
         23. Huella

             - Se validará que la huella o «*hash*» generado sea acorde a las especificaciones y formato detallados en el documento “Especificaciones técnicas para generación de la huella o «*hash*» de los registros de facturación” publicado en Sede Electrónica de la AEAT. En caso contrario, se devolverá un aviso de error (no generará rechazo).
      4. Validaciones de negocio de la agrupación RegistroAnulacion en el bloque RegistroFactura.

         1. Agrupación IDFactura

            - El NIF del campo IDEmisorFacturaAnulada debe ser el mismo que el del campo NIF de la agrupación ObligadoEmision del bloque Cabecera.
         2. GeneradoPor

            - Si se informa este campo, deberá informarse la agrupación Generador.
         3. Agrupación Generador

            * Si se informa esta agrupación, debe haberse informado el campo GeneradoPor.
            * Si se identifica mediante NIF, el NIF debe estar identificado y ser distinto del campo NIF de la agrupación ObligadoEmisión del bloque Cabecera.
            * Si se cumplimenta NIF, no deberá existir la agrupación IDOtro y viceversa, pero es obligatorio que se cumplimente uno de los dos.
            * Si el campo IDType = “02” (NIF-IVA), no será exigible el campo CodigoPais.
            * Cuando el generador se identifique a través de la agrupación IDOtro e IDType sea “02”, se validará que el campo identificador ID se ajuste a la estructura de NIF-IVA de alguno de los Estados Miembros y debe estar identificado. Ver nota (1).
            * Si el valor de GeneradoPor es igual a “E”, debe estar relleno el campo NIF en el generador.
            * Si el valor de GeneradoPor es igual a “D”, cuando el Generador se identifique a través del bloque IDOtro y CodigoPais sea "ES", se validará que el campo IDType sea “03” o “07”.
            * Si el valor del campo GeneradoPor es igual a “T”:

              + Si se identifica a través de la agrupación IDOtro y CodigoPais sea "ES", se validará que el campo IDType sea “03”.
              + No se admite el tipo de identificación IDType “07” (“No censado”).
         4. Huella (del registro anterior)

            - Se validará que la huella del encadenamiento del registro anterior cumpla el formato de salida del algoritmo SHA-256, siendo de 64 caracteres en hexadecimal y en mayúsculas. En caso contrario se devolverá un aviso de error (no generará rechazo).
         5. Agrupación SistemaInformatico

            Ver las validaciones que le aplican en su apartado correspondiente.
         6. FechaHoraHusoGenRegistro

            Se validará que la FechaHoraHusoGenRegistro sea menor o igual que la fecha del sistema de la AEAT, admitiéndose un margen de error. En caso de superar el umbral, se devolverá un aviso de error (no generará rechazo).
         7. Huella

            - Se validará que la huella o «*hash*» generado sea acorde a las especificaciones y formato detallados en el documento “Especificaciones técnicas para generación de la huella o «*hash*» de los registros de facturación” publicado en Sede Electrónica de la AEAT. En caso contrario, se devolverá un aviso de error (no generará rechazo).
      5. Validaciones de negocio de la agrupación SistemaInformatico en las agrupaciones RegistroAlta y RegistroAnulacion del bloque RegistroFactura.

         1. Agrupación SistemaInformatico

            * Si se cumplimenta NIF, no deberá existir la agrupación IDOtro y viceversa, pero es obligatorio que se cumplimente uno de los dos.
            * Si el campo IDType = “02” (NIF-IVA), no será exigible el campo CodigoPais.
            * Cuando la persona o entidad productora del sistema informático se identifique a través de la agrupación IDOtro e IDType sea “02”, se validará que el campo identificador se ajuste a la estructura de NIF-IVA de alguno de los Estados Miembros y debe estar identificado. Ver nota (1).
            * Si se identifica a través de la agrupación IDOtro y CodigoPais sea "ES", se validará que el campo IDType sea “03”.
            * No se admite el tipo de identificación IDType “07” (“No censado”).
            * El campo IdSistemaInformatico deberá tener rellenas siempre las dos posiciones, cada una de las cuales deberá ser una letra mayúscula, excepto la Ñ, o un dígito numérico.
            * El campo NombreSistemaInformatico es obligatorio y debe tener contenido.
            * El campo TipoUsoPosibleSoloVerifactu es obligatorio y debe tener contenido.
            * El campo TipoUsoPosibleMultiOT es obligatorio y debe tener contenido.

              Nota (1)

              [-Sólo se admiten mayúsculas de acuerdo con las directrices de la Comisión:](https://ec.europa.eu/taxation_customs/vies/help.html) <https://ec.europa.eu/taxation_customs/vies/help.html>

              <https://ec.europa.eu/taxation_customs/vies/faq.html#item_11>

              Estructura NIF-IVA.

              País Cód. País Número

              |  |  |  |
              | --- | --- | --- |
              | Alemania | DE | 9 caracteres numéricos |
              | Austria | AT | 9 caracteres alfanuméricos |
              | Bélgica | BE | 10 caracteres numéricos |
              | Chipre | CY | 9 caracteres alfanuméricos |
              | Checa, República | CZ | 8, 9 ó 10 caracteres numéricos |
              | Croacia | HR | 11 caracteres numéricos |
              | Dinamarca | DK | 8 caracteres numéricos |
              | Eslovaquia | SK | 10 caracteres numéricos |
              | Eslovenia | SI | 8 caracteres numéricos |
              | Estonia | EE | 9 caracteres numéricos |
              | Finlandia | FI | 8 caracteres numéricos |
              | Francia | FR | 11 caracteres alfanumérico |
              | Grecia | EL | 9 caracteres numéricos |
              | Irlanda del Norte | GB o XI (\*) | 5, 9 ó 12 caracteres alfanuméricos |
              | Holanda | NL | 12 caracteres alfanumérico |
              | Hungría | HU | 8 caracteres numéricos |
              | Italia | IT | 11 caracteres numéricos |
              | Irlanda | IE | 8 ó 9 caracteres alfanuméricos |
              | Letonia | LV | 11 caracteres numéricos |
              | Lituania | LT | 9 ó 12 caracteres numéricos |
              | Luxemburgo | LU | 8 caracteres numéricos |
              | Malta | MT | 8 caracteres numéricos |
              | Polonia | PL | 10 caracteres numéricos |
              | Portugal | PT | 9 caracteres numéricos |
              | Suecia |  | SE | 12 caracteres numéricos |
              | Bulgaria |  | BG | 9 ó 10 caracteres numéricos |
              | Rumanía |  | RO | de 2 a 10 caracteres numéricos sin ceros a la izquierda |

              (\*) BREXIT: NIF-IVA (NVAT) admisibles para Reino Unido:

              + Si FechaOperacion (FechaExpedicionFactura si no se informa FechaOperacion) es anterior a 01/01/2021 el NVAT tiene que comenzar por “GB”.
              + Si FechaOperacion (FechaExpedicionFactura si no se informa FechaOperacion) es mayor o igual que 01/01/2021 y menor o igual que 31/01/2021 puede empezar por “GB” o “XI”.
              + -Si FechaOperacion (FechaExpedicionFactura si no se informa FechaOperacion) es mayor o igual que 01/02/2021 tiene que empezar por “XI”.

            [Enlace web Comisión para comprobar la estructura de los NIF-IVA:](http://ec.europa.eu/taxation_customs/vies/faqvies.do#item_11) <http://ec.europa.eu/taxation_customs/vies/faqvies.do#item_11>

## 4. GESTIÓN DE ERRORES

   Las peticiones realizadas a través de los servicios web devolverán una respuesta en la que se indicará tanto el resultado global del envío, como el resultado específico de cada registro. El resultado global del envío estará incluido en uno de los siguientes estados:

   * Aceptación completa
   * Aceptación parcial
   * Rechazo completo

El resultado parcial de cada registro incluido en la petición se encontrará en uno de los siguientes estados:
  
   * Aceptado
   * Aceptado con errores
   * Rechazado

   
   1. Descripción de estados globales de una petición

      Aceptación completa

      Una presentación cuyo resultado sea la aceptación completa de la misma, indicará que todos los registros incluidos en la misma han pasado tanto las validaciones sintácticas, como las de negocio y que por tanto han sido registradas de manera satisfactoria por la Agencia.

      Rechazo completo

      Una presentación con un rechazo completo de la misma puede deberse a dos casuísticas:

      1. O bien la estructura definida en la presentación no es conforme al esquema definido (no cumple las validaciones estructurales), o bien, existen errores sintácticos en la cabecera y por ello toda la petición ha de ser rechazada.

         La respuesta se devolverá un mensaje de tipo “*SoapFault*”, en el que se especifica el error concreto.
      2. Todos los registros incluidos en la petición no cumplen las validaciones sintácticas o de negocio (de la cabecera) asociadas y por tanto todas ellas han sido rechazadas.

      Aceptación Parcial

      Una presentación con Aceptación parcial, indicará que no todos los registros incluidos en la misma han sido aceptados correctamente y que por tanto los no aceptados no han pasado algún tipo de validación de las establecidas.

      Solo en el caso de la remisión voluntaria, será necesario el envío de una nueva presentación de los registros erróneos subsanando los errores.

      Este tipo de respuesta se originará cuando existan en un mismo envío registros aceptados (o aceptados con errores) y rechazados.

      En el caso de la remisión bajo requerimiento de la AEAT, no debe subsanar los errores relacionados con las validaciones de negocio de los registros enviados, ya que estos registros deben ser los que se han conservado en el sistema del obligado tributario en el momento de su generación.
   2. Tipos de errores definidos.

      * Errores  “No  admisibles”: son aquellos errores que en ningún caso podrán ser admitidos por la AEAT en la presentación de registros. Se corresponden con los errores provocados al no superar las validaciones sintácticas del envío y a errores de negocio. Estos errores provocan el rechazo del registro de facturación.
      * Errores “Admisibles”: son aquellos errores que no provocan el rechazo del registro. Estos registros serán admitidos por la AEAT.

      La respuesta dada para este tipo de errores será especificada como error, pero de tipo admisible, para dejar constancia al presentador de que se ha producido un error, pero no ha impedido su registro por la AEAT.
   3. Tratamiento de los errores

      1. Tratamiento de los errores en remisión voluntaria «VERIFACTU»

         Los registros de facturación con errores admisibles serán “aceptados” y registrados por los sistemas de la AEAT, pero deberán ser subsanados para poder llevar a cabo el tratamiento y validación de los mismos.

         Los errores admisibles que se han detectado en la versión actual, que deben ser subsanados, son los siguientes:

         * Los NIF informados en la agrupación Destinatario que sean correctos, pero no figuren censados en la AEAT, indicando el tipo de identificación “07” (“No censado”) en el campo “IDType” dentro del bloque “IDOtro”.
         * Se ha informado una huella o *hash* del registro de facturación que no coincide con el calculado por la AEAT.
         * Si el campo ImporteTotal no cumple la validación especificada en cuanto a ajuste de las cantidades (Ʃ (BaseImponibleOimporteNoSujeto + CuotaRepercutida + CuotaRecargoEquivalencia) de todas las líneas de detalle de desglose dentro del margen establecido.
         * Si el campo CuotaTotal no cumple la validación especificada en cuanto a ajuste de las cantidades Ʃ (CuotaRepercutida + CuotaRecargoEquivalencia) de todas las líneas de detalle de desglose dentro del margen establecido.
         * Si el registro de facturación remitido se marca como “PrimerRegistro” a “S” en el bloque de “Encadenamiento” y ya existen registros de facturación para dicho SIF y NIF obligado a emisión.
         * Si se ha informado en el campo FechaHoraHusoGenRegistro una fecha y hora mayor que la fecha del sistema de la AEAT, admitiéndose un margen de error. Se excepciona este error de la necesidad de ser subsanado.

           Solo podrá llevarse a cabo una subsanación cuando no se trate de una causa que exija la emisión de una factura rectificativa (u otro mecanismo contemplado en el Reglamento de Facturación).

           Este mecanismo se empleará para subsanar datos en cualquiera de los siguientes casos:
         * Errores admisibles (registro de facturación aceptado –con errores admisibles– por la AEAT), salvo las excepciones previstas en el apartado que explica el tratamiento de los errores admisibles.
         * Errores no admisibles (registro de facturación rechazado por la AEAT).
         * Dato incorrecto detectado posteriormente por el obligado a expedir factura (registro de facturación remitido y aceptado sin errores por la AEAT).

         Para llevar a cabo la subsanación, será necesaria la remisión de un nuevo registro de facturación (con el mismo identificador de factura del registro de facturación que se quiere subsanar) por cada uno de los registros con datos a subsanar, con la combinación de valores de campos que proceda según el caso (ver en el anexo los cuadros de operativas de alta y anulación admisibles).
      2. Tratamiento de los errores en remisión bajo requerimiento de la AEAT «No VERIFACTU»

         En el caso de la remisión bajo requerimiento de la AEAT, no debe subsanar los errores relacionados con las validaciones de negocio de los registros enviados, ya que estos registros deben ser los que se han conservado en el sistema del obligado tributario en el momento de su generación.

         Todos los errores provocados por validaciones de negocio se marcarán como errores admisibles para no rechazar los registros de facturación conservados en el sistema del obligado tributario, con la única excepción de las validaciones asociadas a la identificación de <NIF> o <IdOtro>.
   4. Listados de códigos de error

      Los listados de códigos de error se pueden consultar a través del siguiente recurso estático publicado en el Portal de Desarrolladores.

      https://prewww2.aeat.es/static\_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/[ws/errores.properties](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/errores.properties)

      Se detallan el listado completo de errores de validación que se pueden producir, con su código y descripción, y organizados en tres categorías:

      * Errores que provocan el rechazo del envío completo
      * Errores que provocan el rechazo de la factura (o de la petición completa si el error se produce en la cabecera)
      * Errores que producen la aceptación del registro de facturación en el sistema (posteriormente deben ser subsanados)

      
## 5. ANEXO: OPERATIVAS DE ALTA Y ANULACIÓN ADMISIBLES -> Operativas de alta y anulación

Se puede encontrar el cuadro de operativas desde: [7 Operativas de alta y anulacion](#7-Operativas-de-alta-y-anulacion)
      
---      

# REMISIÓN VOLUNTARIA Y REMISIÓN BAJO REQUERIMIENTO DE LA AEAT

## 1. Introducción.

Reglamento RD 1007/2023, art. 15, permite obligados tributarios remitir voluntariamente AEAT registros facturación de sistemas informáticos, según especificaciones técnicas Orden Ministerial HAC7/1177/2024. AEAT publicará detalles en sede electrónica.
Este doc. detalla requisitos técnicos para remisión registros facturación.
Se usarán servicios web (estándares, alta funcionalidad) para envío registros tiempo real.
Doc. recoge servicios web para envío voluntario (sistemas VERIFACTU) y respuesta a requerimientos.
Existe un único formato de registro de facturación para remisión voluntaria y para contestar requerimientos.

## 3. Esquema general de funcionamiento.

   Sistemas remiten registros facturación telemáticamente vía Servicios Web SOAP con mensajes XML. Respuestas síncronas. Sistemas deben procesar respuestas.

   Un tipo de mensaje contiene registros de alta y anulación. Enviado el XML, AEAT valida formato y reglas de negocio.

   Si falla validación formato XML, se devuelve «SoapFault» con error específico.

   Si supera validación formato XML, se validan reglas negocio, devolviendo respuesta con resultado (aceptación/no AEAT).

   Máx. 1.000 registros/envío.

   Un registro de facturación puede ser aceptado, rechazado o aceptado con errores, según validaciones remisión.

   Con errores, solo se aceptan registros sin motivo de rechazo. Si hay rechazo, obligados tributarios deben subsanar y reenviar registros rechazados.

   Respuesta XML AEAT contendrá relación registros aceptados/rechazados con motivo. También informará CSV como constancia remisión, excepto si todos los registros son rechazados.

   Respuesta incluye resultado global: aceptada (sin errores), aceptada parcialmente (aceptados y rechazados, o aceptados con errores admisibles) y rechazada (todos rechazados).

   Etiqueta *<IDFactura>* identifica unívocamente registro facturación:

   `<NIF> + <NumSerieFactura> + <FechaExpedicionFactura>`.

   Mismo formato XML para remisión voluntaria y por requerimiento AEAT. XSD único facilita migración sistemas no verificables a verificables.

   Aunque XSD es común, hay URLs diferentes para remisión voluntaria y por requerimiento, con posibles diferencias en validaciones de negocio.

   Envíos por servicios web devuelven respuesta con resultado validación global y de cada registro.

Para calificar el resultado global del envío se devolverá uno de los siguientes valores como respuesta:

   * Correcto (Aceptación completa)
   * ParcialmenteCorrecto (Aceptación parcial)
   * Incorrecto (Rechazo completo)

Para calificar el resultado de cada registro de facturación incluido en la remisión se podrá devolver uno de los siguientes valores como respuesta:

   * Correcto (Aceptado)
   * AceptadoConErrores (Aceptado con errores)
   * Incorrecto (Rechazado)

Descripción valores respuesta global remisión.

   Aceptación completa

   Todos los registros pasan validaciones sintácticas y de negocio, registrándose satisfactoriamente.

   Aceptación Parcial

   Existen registros aceptados y rechazados, o aceptados con errores admisibles. No todos los registros pasaron las validaciones.

   En remisión voluntaria, se requiere nueva remisión (previa subsanación) para aceptar registros erróneos.

   En remisión bajo requerimiento AEAT, no subsanar errores validación negocio; registros deben ser los conservados originalmente.

   Rechazo completo

   Dos casuísticas:

   1. Estructura no conforme a esquema o errores sintácticos en cabecera. Se devuelve «SoapFault» con error.
   2. Todos los registros incumplen validaciones sintácticas o de negocio. Se devuelven códigos de error por registro.

   Tipos de Errores definidos.

   Errores “No admisibles”: Provocan rechazo del registro. No admitidos por Agencia Tributaria. Corresponden a fallos en validaciones sintácticas y de negocio.

   Errores “Admisibles”: No provocan rechazo. Registros admitidos por Agencia Tributaria. Respuesta: “Aceptado con errores”, para constancia del error no impeditivo.

   Tratamiento de los errores (no admisibles y admisibles).

   En remisión voluntaria, registros con errores no admisibles (rechazados) y admisibles (registrados) deben subsanarse y reenviarse a AEAT para su validación, si no procede factura rectificativa o anulación.

   En remisión bajo requerimiento AEAT, no subsanar errores de negocio; enviar registros tal como se conservaron.

## 4. Estándares y requisitos.

   1. ### Introducción.

      Mensaje es fichero XML codificado en UTF-8. Doc. XML debe cumplir esquemas (formatos, obligatoriedad). Coherencia de datos garantizada en origen. Esquemas organizados en “Grupos de Datos” con “Elementos de Datos” en bloques lógicos. Remisión por servicio web por obligado tributario, apoderado o colaborador social con certificado electrónico cualificado. NIFs se validan contra BD Centralizada AEAT.
   2. ### Estándares utilizados.

      Servicios Web son base para interacción máquina-máquina (automatización integral). Se usan estándares de facto.

      [Estructura mensajes basada en esquemas XML (recomendación W3C 28-Oct-2004):](http://www.w3.org/TR/xmlschema-0) [http://www.w3.org/TR/xmlschema-0 y namespace http://www.w3.org/2001/XMLSchema](http://www.w3.org/2001/XMLSchema)

      [SOAP V1.1 (NOTA W3C 08-Mayo-2000):](http://www.w3.org/TR/2000/NOTE-SOAP-20000508/) [http://www.w3.org/TR/2000/NOTE-SOAP-20000508/ y namespace http://schemas.xmlsoap.org/soap/envelope/](http://schemas.xmlsoap.org/soap/envelope/)

      SOAP-1.1 usa modo “document” (style = ”document”) sin codificación (use = ”literal”). Mensaje entrada/salida descrito por su esquema XML.

      [Descripción servicios con WSDL 1.1 (NOTA W3C 14-Marzo-2001):](http://www.w3.org/TR/2001/NOTE-wsdl-20010315) [http://www.w3.org/TR/2001/NOTE-wsdl-20010315 y namespace http://schemas.xmlsoap.org/wsdl/](http://schemas.xmlsoap.org/wsdl/)
   3. ### Medio de envío.

      Entorno: Internet.

      Protocolo: HTTPS.

      Mensajes: Web Service con SOAP 1.1 modo Document.

      Certificado: Aplicaciones se autentican con certificado electrónico cualificado.

      Codificación: UTF-8. Entrada es XML según esquema XSD.

## 5. Consideraciones de diseño.

   1. ### Comunicación de incidencias en el procesado de peticiones.

      Incidencias al procesar XML se comunican con elemento “Fault” (SOAP V1.1). Posibles respuestas a remisión:

	| Resultado en el lado cliente | Acción |
	| :--- | :--- |
	| Se recibe respuesta XML esperada. (Admisión o rechazo) | OK. Mensaje procesado |
	| Se recibe respuesta “Fault” con “faultcode” “soapenv:Server” | Reenviar mensaje |
	| Se recibe respuesta “Fault” con “faultcode” “soapenv:Client” | Mensaje mal formado o incorrecto. Comprobar “faultstring” y reenviar. |
	| No progresa transmisión o no se recibe XML esperado | Reenviar mensaje |

## 6. Diseño.

   1. ### Estructura de los mensajes.

      Mensaje remisión: capa “SOAP”, datos en “BODY”.

      Mensaje respuesta: capa “SOAP”, datos en “BODY”.

      1. ### Tipos de mensajes.

         1. Definición del mensaje de remisión.

            Fichero XML “Remisión”:

            * Cabecera.
            * Lista registros facturación.
         2. Alta/Anulación de registros de facturación.

            Estructura genérica remisión:

            ```mermaid
               graph TD;
                   RFSF[RegFactuSistemaFacturacion] --> Cabecera[sfLR:Cabecera];
                   RFSF --> RegistroFactura[sfLR:RegistroFactura 1..1000];

                   subgraph sf:CabeceraType
                       Cabecera --> ObligadoEmision[sf:ObligadoEmision];
                       Cabecera --> Representante[sf:Representante];
                       Cabecera --> RemisionVoluntaria[sf:RemisionVoluntaria];
                       Cabecera --> RemisionRequerimiento[sf:RemisionRequerimiento];
                   end

                   subgraph sf:PersonaFisicaJuridicaESType
                       ObligadoEmision --> OE_NombreRazon[sf:NombreRazon];
                       ObligadoEmision --> OE_NIF[sf:NIF];
                       Representante --> R_NombreRazon[sf:NombreRazon];
                       Representante --> R_NIF[sf:NIF];
                   end

                   subgraph sfLR:RegistroFacturaType
                       RegistroFactura --> RegistroAlta[sf:RegistroAlta];
                       RegistroFactura --> RegistroAnulacion[sf:RegistroAnulacion];
                   end
            ```

            Estructura nodo `<RegistroAlta>`:

            ```mermaid
            graph TD;
                subgraph RegistroAltaType
                    RA[RegistroAlta] --> RFA[sf:RegistroFacturacionAltaType];

                    subgraph sf:RegistroFacturacionAltaType
                        RFA --> IDVersion[sf:IDVersion];
                        RFA --> IDFactura[sf:IDFactura];
                        RFA --> NumComprobanteEmisor[sf:NumComprobanteEmisor];
                        RFA --> FechaEmision[sf:FechaEmision];
                        RFA --> ApunteContable[sf:ApunteContable];
                        RFA --> FacturasRectificadas[sf:FacturasRectificadas];
                        RFA --> FacturasSustituidas[sf:FacturasSustituidas];
                        RFA --> ImporteTotal[sf:ImporteTotal];
                        RFA --> Sujeto[sf:Sujeto];
                        RFA --> Destinatario[sf:Destinatario];
                        RFA --> Desglose[sf:Desglose];
                        RFA --> Encadenamiento[sf:Encadenamiento];
                        RFA --> SistemaInformatico[sf:SistemaInformatico];
                        RFA --> FechaHora[sf:FechaHoraHusoGenRegistro];
                        RFA --> TipoHuella[sf:TipoHuella];
                        RFA --> Huella[sf:Huella];
                        RFA --> Signature[ds:Signature];
                    end

                    subgraph sf:IDFacturaType
                        IDFactura --> ID_NumSerieFactura[sf:NumSerieFactura];
                        IDFactura --> ID_IDEmisorFactura[sf:IDEmisorFactura];
                        IDFactura --> ID_FechaExpedicionFactura[sf:FechaExpedicionFactura];
                    end

                    subgraph sf:DesgloseType
                        Desglose --> DetalleDesglose[sf:DetalleDesglose];
                    end

                    subgraph sf:DetalleType
                        DetalleDesglose --> Impuesto[sf:Impuesto];
                        DetalleDesglose --> BaseImponible[sf:BaseImponible];
                        DetalleDesglose --> TipoImpositivo[sf:TipoImpositivo];
                        DetalleDesglose --> CuotaRepercutida[sf:CuotaRepercutida];
                    end

                    subgraph sf:EncadenamientoType
                        Encadenamiento --> PrimerRegistro[sf:PrimerRegistro];
                        Encadenamiento --> RegistroAnterior[sf:RegistroAnterior];
                    end
                end
            ```

            Estructura nodo `<RegistroAnulacion>`:

            ```mermaid
            graph TD;
               subgraph RegistroAnulacionType
                 RA[RegistroAnulacion] --> RFA[sf:RegistroFacturacionAnulacionType];

                 subgraph sf:RegistroFacturacionAnulacionType
                     RFA --> IDVersion[sf:IDVersion];
                     RFA --> IDFactura[sf:IDFactura];
                     RFA --> RefExterna[sf:RefExterna];
                     RFA --> SinRegistroPrevio[sf:SinRegistroPrevio];
                     RFA --> RechazoPrevio[sf:RechazoPrevio];
                     RFA --> GeneradoPor[sf:GeneradoPor];
                     RFA --> Generador[sf:Generador];
                     RFA --> Encadenamiento[sf:Encadenamiento];
                     RFA --> SistemaInformatico[sf:SistemaInformatico];
                     RFA --> FechaHora[sf:FechaHoraHusoGenRegistro];
                     RFA --> TipoHuella[sf:TipoHuella];
                     RFA --> Huella[sf:Huella];
                     RFA --> Signature[ds:Signature];
                 end

                 subgraph sf:IDFacturaExpedidaBajaType
                     IDFactura --> IDEmisorFacturaAnulada[sf:IDEmisorFacturaAnulada];
                     IDFactura --> NumSerieFacturaAnulada[sf:NumSerieFacturaAnulada];
                     IDFactura --> FechaExpedicionFacturaAnulada[sf:FechaExpedicionFacturaAnulada];
                 end

                 subgraph sf:PersonaFisicaJuridicaType
                     Generador --> NombreRazon[sf:NombreRazon];
                     Generador --> NIF[sf:NIF];
                     Generador --> IDOtro[sf:IDOtro];
                 end

                 subgraph sf:EncadenamientoFacturaAnterior...
                     Encadenamiento --> PrimerRegistro[sf:PrimerRegistro];
                     Encadenamiento --> RegistroAnterior[sf:RegistroAnterior];
                     RegistroAnterior --> Enc_IDEmisorFactura[sf:IDEmisorFactura];
                     RegistroAnterior --> Enc_NumSerieFactura[sf:NumSerieFactura];
                     RegistroAnterior --> Enc_FechaExpedicionFactura[sf:FechaExpedicionFactura];
                     RegistroAnterior --> Enc_Huella[sf:Huella];
                 end

                 subgraph sf:SistemaInformaticoType
                     SistemaInformatico --> SI_NombreRazon[sf:NombreRazon];
                     SistemaInformatico --> SI_NIF[sf:NIF];
                     SistemaInformatico --> SI_IDOtro[sf:IDOtro];
                     SistemaInformatico --> NombreSistemaInformatico[sf:NombreSistemaInformatico];
                     SistemaInformatico --> IDSistemaInformatico[sf:IDVersion];
                     SistemaInformatico --> NumeroInstalacion[sf:NumeroInstalacion];
                 end
               end
            ```

         3. Consulta registros facturación presentados (solo remisión voluntaria «VERIFACTU»).

            Estructura genérica remisión:

            ```mermaid
            graph TD;
                CFSF[ConsultaFactuSistemaFacturacion] --> Consulta[sfR:CC:ConsultaFactuSistemaFact...];

                subgraph sfR:CC:ConsultaFactuSistemaFact...
                    Consulta --> Cabecera[sfR:Cabecera];
                    Consulta --> FiltroConsulta[sfR:FiltroConsulta];
                    Consulta --> DatosAdicionalesRespuesta[sfR:DatosAdicionalesRespuesta];
                end

                subgraph sfR:Cabecera...
                    Cabecera --> Version[Version];
                    Cabecera --> ObligadoEmision[sf:ObligadoEmisionConsultaType];
                    Cabecera --> IndicadorRepresentante[IndicadorRepresentante];
                end

                subgraph sfR:BC:FiltroFacturacionType
                    FiltroConsulta --> PeriodoImpositivo[sfR:PeriodoImpositivo];
                    FiltroConsulta --> Contraparte[sfR:Contraparte];
                    FiltroConsulta --> FechaExpedicionFactura[sfR:FechaExpedicionFactura];
                    FiltroConsulta --> SistemaInformatico[sf:SistemaInformaticoConsultaType];
                    FiltroConsulta --> RefExterna[sf:RefExterna];
                    FiltroConsulta --> ClavePaginacion[sf:ClavePaginacion];
                end

                subgraph sfR:DatosAdicionales...
                    DatosAdicionalesRespuesta --> MostrarNombreRazonEmisor[sfR:BC:MostrarNombreRazonEmisor];
                    DatosAdicionalesRespuesta --> MostrarSistemaInformatico[sfR:BC:MostrarSistemaInformatico];
                end
            ```
         4. Definición de los mensajes de respuesta.

            Fichero XML “Respuesta” AEAT.

            Si remisión se recibe y procesa correctamente, se responde con XML “Respuesta” compuesto de:

            * Cabecera.
            * Lista registros aceptados y rechazados.
         5. Respuesta Alta/Anulación de registros de facturación.

            Estructura respuesta:

            ```mermaid
            graph TD;
                RFSF[RespuestaRegFactuSistemaFactu...] --> Respuesta[srlr:RespuestaRegFactuSistemaFact...];

                subgraph srlr:RespuestaRegFactuSistemaFact...
                    Respuesta --> CSV[srlr:CSV];
                    Respuesta --> DatosPresentacion[srlr:DatosPresentacion];
                    Respuesta --> Cabecera[srlr:Cabecera];
                    Respuesta --> TiempoEsperaEnvio[srlr:TiempoEsperaEnvio];
                    Respuesta --> EstadoEnvio[srlr:EstadoEnvio];
                    Respuesta --> RespuestaLinea[srlr:RespuestaLinea];
                end

                subgraph sf:CabeceraType
                    Cabecera --> ObligadoEmision[sf:ObligadoEmision];
                    Cabecera --> Representante[sf:Representante];
                    Cabecera --> FechaFinVeriFactu[sf:FechaFinVeriFactu];
                end

                subgraph srlr:RespuestaExpedidaType
                    RespuestaLinea --> IDFactura[srlr:IDFactura];
                    RespuestaLinea --> Operacion[srlr:Operacion];
                    RespuestaLinea --> RefExterna[srlr:RefExterna];
                    RespuestaLinea --> EstadoRegistro[srlr:EstadoRegistro];
                    RespuestaLinea --> CodigoErrorRegistro[srlr:CodigoErrorRegistro];
                    RespuestaLinea --> DescripcionErrorRegistro[srlr:DescripcionErrorRegistro];
                    RespuestaLinea --> RegistroDuplicado[srlr:RegistroDuplicado];
                end

                subgraph srlr:IDFactura
                    IDFactura --> IDEmisorFactura[sf:IDEmisorFactura];
                    IDFactura --> NumSerieFactura[sf:NumSerieFactura];
                    IDFactura --> FechaExpedicionFactura[sf:FechaExpedicionFactura];
                end
            ```
         6. Respuesta Consulta registros facturación presentados.

            Estructura respuesta (podría no ser certero):

            ```mermaid
            graph TD;
                DAFE[DeclaracionAnualFacturasEmitidas] --> Cabecera[sLR:Cabecera];
                DAFE --> RDFE[sLR:RegistroDeclaracionAnualFacturasEmitidas];

                subgraph sLR:CabeceraType
                    Cabecera --> ObligadoEmision[sf:ObligadoEmision];
                    Cabecera --> Representante[sf:Representante];
                    Cabecera --> RemisionVoluntaria[sf:RemisionVoluntaria];
                end

                subgraph sLR:RegistroDeclaracionAnualFacturasEmitidasType
                    RDFE --> PeriodoImpositivo[PeriodoImpositivo];
                    RDFE --> IDFacturas[IDFacturas];
                    RDFE --> Contraparte[Contraparte];
                    RDFE --> DesgloseFactura[DesgloseFactura];
                    RDFE --> Macrodato[Macrodato];
                    RDFE --> Huella[Huella];
                end

                subgraph PeriodoImpositivo
                    PeriodoImpositivo --> Ejercicio;
                    PeriodoImpositivo --> Periodo;
                end

                subgraph Contraparte
                    Contraparte --> NombreRazon;
                    Contraparte --> NIF;
                    Contraparte --> IDOtro;
                end

                subgraph DesgloseFactura
                    DesgloseFactura --> Sujeta;
                    DesgloseFactura --> NoSujeta;
                end

                subgraph Sujeta
                    Sujeta --> Exenta;
                    Sujeta --> NoExenta;
                end

                subgraph NoExenta
                    NoExenta --> TipoNoExenta;
                    NoExenta --> DesgloseOperacion;
                end

                subgraph DesgloseOperacion
                    DesgloseOperacion --> Entrega;
                    DesgloseOperacion --> PrestacionServicios;
                end

                subgraph IDFacturas
                    IDFacturas --> IDFactura[IDFactura];
                    IDFacturas --> DatosFactura[DatosFactura];
                    IDFacturas --> FacturaRectificativa[FacturaRectificativa];
                    IDFacturas --> ImporteTotal[ImporteTotal];
                    IDFacturas --> DatosInmueble[DatosInmueble];
                end
            ```

            Fichero XML “SOAPFault”:

            Si mensaje “Remisión” tiene errores validación formato XML y/o cabecera, se genera respuesta “SOAPFault” y se rechaza envío completo.

            Ej. mensaje XML respuesta “SOAPFault”:
            
			```xml
            <?xml version="1.0" encoding="UTF-8"?>
            <env:Envelope xmlns:env[="](http://schemas.xmlsoap.org/soap/envelope/)http://schemas.xmlsoap.org/soap/envelope/">
            <env:Body>
            <env:Fault>
            <faultcode>env:Client</faultcode>
            <faultstring>Codigo[4104].El NIF del titular en la cabecera no está identificado.
            NIF:iii. NOMBRE\_RAZON:xxx
            </faultstring>
            <detail>
            <callstack>WSExcepcion [faultcode=null, detailMap=null, version=0,. </callstack>
            </detail>
            </env:Fault>
            </env:Body>
            </env:Envelope>
            ```
            
      2. ### Especificación funcional del mensaje de remisión.

         Publicado en sede electrónica AEAT, doc. independiente, en Portal Desarrolladores:

         [Enlace al Portal de desarrolladores de la AEAT.](https://www.agenciatributaria.es/AEAT.desarrolladores/Desarrolladores/_menu_/Documentacion/Sistemas_Informaticos_de_Facturacion_y_Sistemas_VERI_FACTU/Sistemas_Informaticos_de_Facturacion_y_Sistemas_VERI_FACTU.html)
         
      3. ### Especificación funcional consulta registros facturación presentados (solo remisión voluntaria «VERIFACTU»).

         Se consultan registros presentados por emisor en remisión voluntaria, filtrando obligatoriamente por ejercicio/periodo (fecha operación/expedición). Filtros opcionales para acotar. Se permite consulta por emisor (<ObligadoEmision>) o destinatario (<Destinatario>). Consultas por ejercicio/periodo de imputación. Máx. 10.000 registros por respuesta. Para más datos, usar consulta paginada (Ver 6.4.3) con ID último registro.

	     1. Consulta de los registos de facturación presentados
	
	        Estructura petición:

       | BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / (LONGITUD) / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Cabecera**¹ | **IDVersion**¹ | | | Versión actual esquema para generación/conservación/remisión registros. Parte de circunstancias de generación. | Alfanumérico (3) L15 |
| | **ObligadoEmision**¹² | **NombreRazon**¹ | | Nombre-razón social obligado a expedir facturas. | Alfanumérico (120) |
| | | NIF¹ | | NIF obligado a expedir facturas. | FormatoNIF (9) |
| | **Destinatario**¹² | **NombreRazon**¹ | | Nombre-razón social destinatario (cliente). | Alfanumérico (120) |
| | | **NIF**¹ | | NIF destinatario (cliente). | FormatoNIF (9) |
| | IndicadorRepresentante | | | Flag opcional (valor S) si consulta la realiza representante/asesor. Permite obtener registros donde figura como representante. Solo si está informado el obligado tributario. | Alfanumérico (1) L1C |
| **FiltroConsulta** | **PeriodoImputacion**¹ | **Ejercicio**¹ | | Año fecha operación a consultar (de fecha operación o expedición). | Númerico(4), formato YYYY |
| | | **Periodo**¹ | | Mes fecha operación a consultar (de fecha operación o expedición). | Alfanumérico (2) L2C |
| | NumSerieFactura | | | Nº Serie+Nº Factura que identifica registro. | Alfanumérico (60) |
| | **Contraparte**² | **NombreRazon**¹ | | Nombre-razón social contraparte NIF cabecera. Obligado emisor si consulta Destinatario. Destinatario si consulta Obligado. | Alfanumérico (120) |
| | | **NIF**¹² | | NIF contraparte NIF cabecera. Obligado emisor si consulta Destinatario. Destinatario si consulta Obligado. | FormatoNIF (9) |
| | | **IDOtro**¹² | CodigoPais | Clave tipo identificación país residencia contraparte. Obligado emisor si consulta Destinatario. Destinatario si consulta Obligado. | Alfanumérico (2) (ISO 3166-1 alpha-2 codes) |
| | | | IDType | Clave tipo identificación país residencia contraparte. Obligado emisor si consulta Destinatario. Destinatario si consulta Obligado. | Alfanumérico (2) L7 |
| | | | ID | Nº identificación país residencia contraparte. Obligado emisor si consulta Destinatario. Destinatario si consulta Obligado. | Alfanumérico (20) |
| | **FechaExpedicionFactura**¹ | **FechaExpedicionFactura**¹² | | Fecha emisión registro facturación. | Fecha (dd-mm-yyyy) |
| | **RangoFechaExpedicion**¹² | Desde | | Fecha desde la que se consulta. | Fecha (dd-mm-yyyy) |
| | | Hasta | | Fecha hasta la que se consulta. | Fecha (dd-mm-yyyy) |
| | SistemaInformatico | | | Datos sistema informático facturación. Ver diseño bloque: «SistemaInformatico» en doc. alta/anulación. | |
| | RefExterna | | | Dato adicional libre para asociar info. interna sistema facturación al registro. | Alfanumérico (60) |
| | ClavePaginacion | **IDEmisorFactura**¹ | | NIF obligado a expedir factura (última consultada). | FormatoNIF (9) |
| | | **NumSerieFactura**¹ | | Nº Serie+Nº Factura que identifica registro (último consultado). | Alfanumérico (60) |
| | | **FechaExpedicionFactura**¹ | | Fecha emisión registro (último consultado). | Fecha (dd-mm-yyyy) |
| **DatosAdicionalesRespuesta** | MostrarNombreRazonEmisor | | | Indicador (S/N) para obtener en respuesta campo NombreRazonEmisor. Valor S aumenta tiempo respuesta en consulta por destinatario. Por defecto "N". | Alfanumérico(1)<br>Valores posibles: "S" o "N" |
| | MostrarSistemaInformatico | | | Indicador (S/N) para obtener en respuesta bloque SistemaInformatico. Valor S aumenta tiempo respuesta. Si consulta por Destinatario, valor debe ser "N" o no cumplimentado. | Alfanumérico(1)<br>Valores posibles: "S" o "N" |

	Nota:Campos en negrita son obligatorios. Campos con superíndice 2 son seleccionables.
		            
	2. Respuesta de la consulta de los registos de facturación presentados

		| BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DESCRIPCIÓN | FORMATO / LONGITUD / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Cabecera**¹ | **IDVersion** | | | Versión esquema utilizado para intercambio info. | Alfanumérico(3) L15 |
| | **ObligadoEmision**¹² | **NombreRazon** | | Nombre-razón social del consultado. | Alfanumérico(120) |
| | | **NIF** | | NIF del obligado consultado. | FormatoNIF(9) |
| | **Destinatario**¹² | **NombreRazon** | | Nombre-razón social del consultado. | Alfanumérico(120) |
| | | **NIF** | | NIF del consultado. | FormatoNIF(9) |
| | IndicadorRepresentante | | | Indica si actúa como representante o en nombre propio. | Alfanumérico (1) L1C |
| **PeriodoImputacion**¹ | **Ejercicio** | | | Ejercicio consultado. | Númerico(4), formato YYYY |
| | **Periodo** | | | Periodo consultado. | Alfanumérico (2) L2C |
| **IndicadorPaginacion**¹ | | | | Indica si hay más registros en consulta (Ver 6.4.3). Si valor "S", realizar nuevas consultas con ID último registro. | Alfanumérico(1)<br>Valores posibles: "S" o "N" |
| **ResultadoConsulta**¹ | | | | Indica si hay registros para la consulta. | Alfanumérico(8)<br>Valores posibles: "ConDatos" o "SinDatos" |
| **RespuestaConsultaFactuSistemaFac** | | | | Bloque con todos los campos de una factura. Máx. 10.000 facturas (bloque se repite máx. 10.000 veces). | |
| | **IDFactura** | | | Bloque con campos que identifican registro. | |
| | **DatosRegistroFacturacion** | | | Bloque con campos del registro. | |
| | DatosPresentacion | | | Bloque con info. presentación:<br>`<NIFPresentador>`<br>`<TimestampPresentacion>`<br>`<IdPeticion>` | |
| | **EstadoRegistro** | | | Bloque con estado del registro:<br>`<TimestampUltimaModificacion>`<br>`<EstadoRegistro>`<br>`<CodigoErrorRegistro>`<br>`<DescripcionErrorRegistro>` | |
| **ClavePaginacion** | **IDEmisorFactura**¹ | | | NIF obligado a expedir factura (última consultada).<br>Solo si IndicadorPaginacion=S | FormatoNIF (9) |
| | **NumSerieFactura**¹ | | | Nº Serie+Nº Factura que identifica registro (último consultado).<br>Solo si IndicadorPaginacion=S | Alfanumérico (60) |
| | **FechaExpedicionFactura**¹ | | | Fecha emisión registro (última consultada).<br>Solo si IndicadorPaginacion=S | Fecha (dd-mm-yyyy) |

		Nota:Campos en negrita son obligatorios. Campos con superíndice 2 son seleccionables.
            
         3. Consulta paginada

            Si respuesta supera 10.000 registros, invocar servicio de forma paginada. Respuesta tendrá <IndicadorPaginacion>="S" y <ClavePaginacion> con último registro. Para obtener resto, enviar nueva petición con <ClavePaginacion> de respuesta anterior. Sin <ClavePaginacion>, se devuelven los primeros 10.000 registros.
         4. Respuesta de alta y anulación de registros de facturación.

           | BLOQUE | DATOS/ AGRUPACIÓN | DATOS/ AGRUPACIÓN | DATOS | DESCRIPCIÓN | FORMATO / LONGITUD / LISTA |
| :--- | :--- | :--- | :--- | :--- | :--- |
| CSV | | | | CSV asociado a remisión. IMPORTANTE: Almacenar en SIF al dar de alta, no recuperable después. | Alfanumérico(16) |
| DatosPresentacion | **NIFPresentador**¹ | | | NIF del presentador. | FormatoNIF(9) |
| | **TimestampPresentacion**¹ | | | Timestamp remisión (huso horario servidores AEAT). | DateTime. Formato: YYYY-MM-DDThh:mm:ssTZD (ej: 2024-01-01T19:20:30+01:00) (ISO 8601) |
| **Cabecera**¹ | | | | Cabecera equivalente a la enviada en remisión alta/anulación. | |
| **TiempoEsperaEnvio**¹ | | | | Segundos espera entre envíos. Siguiente envío tras <TiempoEsperaEnvio> segundos o al alcanzar límite registros, lo que ocurra primero. | Numérico |
| **EstadoEnvio**¹ | | | | Especifica si conjunto de registros fue admitido, rechazado o aceptado parcialmente. | Alfanumérico(20) L18 |
| **RespuestaLinea (0..1000)**¹ | **IDFactura**¹ | | | Identificador del registro especificado en remisión. | |
| | **Operacion**¹ | **TipoOperacion**¹ | | Tipo operación: "Alta" o "Anulacion". | Alfanumérico(9) L22 |
| | | Subsanacion | | Indicador "Subsanacion" especificado en remisión alta. | Alfanumérico (1) L4 |
| | | RechazoPrevio | | Indicador "RechazoPrevio" especificado en remisión alta/anulación. | Alfanumérico (1) L17 |
| | | SinRegistroPrevio | | Indicador "SinRegistroPrevio" especificado en remisión anulación. | Alfanumérico (1) L4 |
| | RefExterna | | | Dato adicional libre especificado en remisión. | Alfanumérico(60) |
| | **EstadoRegistro**¹ | | | Especifica si registro fue registrado correctamente, rechazado o registrado con errores. | Alfanumérico(18) L19 |
| | CodigoErrorRegistro | | | Código que identifica error en registro. | Alfanumérico(5) L20 |
| | DescripcionErrorRegistro | | | Descripción del error en registro. | Alfanumérico(500) |
| | RegistroDuplicado | **IdPeticionRegistroDuplicado**¹ | | IdPeticion asociado a registro almacenado previamente. Solo si registro es rechazado por duplicado. | Alfanumérico(20) |
| | | **EstadoRegistroDuplicado**¹ | | Estado registro almacenado previamente: Correcta, AceptadaConErrores, Anulada. Solo si registro es rechazado por duplicado. | Alfanumérico(18) L21 |
| | | CodigoErrorRegistro | | Código error registro almacenado previamente. | Alfanumérico(5) L20 |
| | | DescripcionErrorRegistro | | Descripción error registro duplicado. | Alfanumérico(500) |


		1. #### Mecanismo de control de flujo.

      Art. 16.2 orden:

      1. Sistemas «VERIFACTU» implementarán control flujo basado en tiempo espera (inicial 60s) y máx. registros/envío.

         Respuesta AEAT informa del tiempo espera para siguiente envío.

         Máx. registros/envío según diseño registro anexo 2.2. Funcionamiento:

         1. Sistema informático envía primer conjunto registros.
         2. AEAT devuelve tiempo espera actualizado «t».
         3. Para siguiente envío, esperar «t» segundos o acumular máx. registros, lo que ocurra primero.
         4. Sistema realiza nuevo envío cumpliendo c). Puede recibir nuevo valor «t».

      Ej. respuesta con tiempo espera 60s:

      `<sf:TiempoEsperaEnvio>60</sf:TiempoEsperaEnvio>`

      2. ### Valores permitidos en campos de tipo lista.

         1. Alta, anulación y consulta de registros de facturación.

            Recogido en apartado 6 anexo orden. Publicado en sede electrónica AEAT, doc. independiente, en Portal Desarrolladores:


            1. Consulta de registros de facturación.

               L1C -> Indicador Representante

               |  |  |
               | --- | --- |
               | VALORES | DESCRIPCIÓN |
               | S | Sí |

               L2C -> Periodo

               |  |  |
               | --- | --- |
               | VALORES | DESCRIPCIÓN |
               | 01 | Enero |
               | 02 | Febrero |
               | 03 | Marzo |

               |  |  |
               | --- | --- |
               | 04 | Abril |
               | 05 | Mayo |
               | 06 | Junio |
               | 07 | Julio |
               | 08 | Agosto |
               | 09 | Septiembre |
               | 10 | Octubre |
               | 11 | Noviembre |
               | 12 | Diciembre |
               
            2. Respuesta de alta y anulación de registros de facturación.

	            L18 -> Estado global envío (respuesta).
	
	            |  |  |
	            | --- | --- |
	            | VALORES | DESCRIPCIÓN |
	            | Correcto | Todos los registros de la remisión tienen estado “Correcto”. |
	            | ParcialmenteCorrecto | Algunos registros tienen estado “Incorrecto” o “AceptadoConErrores”. |
	            | Incorrecto | Todos los registros tienen estado “Incorrecto”. |
	
	            L19 -> Estado envío registro (respuesta).
	
	            Campo **<EstadoRegistro>** en respuesta alta/anulación. Especifica si registro se valida y registra.
	
	            |  |  |
	            | --- | --- |
	            | VALORES | DESCRIPCIÓN |
	            | Correcto | Registro totalmente correcto y registrado. |
	            | AceptadoConErrores | Registro con errores no impeditivos. Registrado. |
	            | Incorrecto | Registro con errores impeditivos. No registrado. |
	
	            L20 -> Código de error de registro.
	
	            Lista completa de errores en doc. de validaciones.
	
	            L21 -> Estado registro factura (respuesta a rechazo por duplicado).
	
	            Campo ***<EstadoRegistroDuplicado>***. Especifica estado registro almacenado previamente.
	
	            |  |  |
	            | --- | --- |
	            | VALORES | DESCRIPCIÓN |
	            | Correcta | Registro previo es correcto. |
	            | AceptadaConErrores | Registro previo tiene errores. |
	            | Anulada | Registro previo ha sido anulado mediante operación de anulación. |
	
	            L22 -> Tipo de operación realizada en el registro de facturación
	
	            |  |  |
	            | --- | --- |
	            | VALORES | DESCRIPCIÓN |
	            | Alta | Operación de alta. |
	            | Anulacion | Operación de anulación. |
	            
      3. ### Remisión voluntaria y bajo requerimiento.

         Remisión voluntaria: obligados tributarios remiten inmediatamente todos los registros de facturación generados.

         Bajo requerimiento: obligado tributario suministra registros conservados.

         Formato registro y XSD único para ambos casos. URLs y sistemas gestión AEAT diferentes, sin compartir registros.

         Definición servicios web en siguiente WSDL:
         
         ```xml
         <stripped/>
         ```

		```mermaid
		graph LR
		    subgraph "PortTypes (Interfaces)"
		        PortVerifactu["sFPortTypeVerifactu<br>- ConsultaFactuSistemaFacturacion"]
		        PortRequerimiento["sFPortTypePorRequerimiento<br>- RegFactuSistemaFacturacion"]
		    end
		
		    subgraph "Bindings (SOAP)"
		        BindingVerifactu["<b>sVerifactu</b><br>soap<br>- RegFactuSistemaFacturacion<br>- ConsultaFactuSistemaFacturacion"]
		        BindingRequerimiento["<b>sRequerimiento</b><br>soap<br>- RegFactuSistemaFacturacion"]
		    end
		
		    subgraph "Services & Endpoints"
		        ServiceVerifactu["<b>sfVerifactu</b><br>---<br><i>SistemaVerifactu</i><br><i>SistemaVerifactuSello</i><br><i>SistemaVerifactuPruebas</i><br><i>SistemaVerifactuSelloPruebas</i>"]
		        ServiceRequerimiento["<b>sfRequerimiento</b><br>---<br><i>SistemaRequerimiento</i><br><i>SistemaRequerimientoSello</i><br><i>SistemaRequerimientoPruebas</i><br><i>SistemaRequerimientoSelloPruebas</i>"]
		    end
		
		    PortVerifactu --> BindingVerifactu
		    PortRequerimiento --> BindingRequerimiento
		    BindingVerifactu --> ServiceVerifactu
		    BindingRequerimiento --> ServiceRequerimiento
		
		    style PortVerifactu fill:#E6E6FA,stroke:#333,stroke-width:2px
		    style PortRequerimiento fill:#E6E6FA,stroke:#333,stroke-width:2px
		    style BindingVerifactu fill:#D7EAFB,stroke:#333,stroke-width:2px
		    style BindingRequerimiento fill:#D7EAFB,stroke:#333,stroke-width:2px
		    style ServiceVerifactu fill:#D5F5E3,stroke:#333,stroke-width:2px
		    style ServiceRequerimiento fill:#D5F5E3,stroke:#333,stroke-width:2px
	    ```

      4. ### Tratamiento cadenas de texto en campos XML

         No usar espacios en blanco al inicio/final de cadenas. Se eliminarán automáticamente, reflejándose en respuesta y almacenamiento AEAT.

         Ej: `<NumSerieFactura> 12345678 / G33 </NumSerieFactura>` se almacena como "12345678 / G33".
         
      5. ### Valores permitidos en campos numéricos.

         No usar ceros a la izquierda (ej: usar 1, no 01). Ceros a la derecha tras punto decimal indican precisión (12345.7 es igual a 12345.70).

         (Nota: en fechas, sí usar ceros a la izquierda (ej: 02-07-2014).
         
      6. ### Aclaración sobre escapado de caracteres especiales.

      Si es necesario usar los siguientes caracteres en un valor XML, usar las entidades correspondientes:

      
      | Carácter | Carácter escapado |
      | :--- | :--- |
      | & | &amp; |
      | < | &lt; |
      
## 7. Anexo I: Definición de servicios y esquemas (entorno de PRUEBAS).

   Definición servicios y esquemas v1.0.

   1. ### Definición de servicios.

      Definición servicios (WSDL):

      [Definición de los servicios:](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SistemaFacturacion.wsdl) 
      
   2. ### Esquemas de Entrada

      Esquemas mensajes entrada:

      * [“SuministroInformacion.xsd”. Definición tipos comunes:](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroInformacion.xsd) <https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroInformacion.xsd>

      * [“SuministroLR.xsd”. Esquema operaciones (Alta y Anulación):](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroLR.xsd)


      * [ConsultaLR.xsd. Esquema operación consulta.](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/ConsultaLR.xsd) <https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/ConsultaLR.xsd>
   3. ### Esquemas de Salida.

      Esquemas mensajes respuesta:

      * [“RespuestaSuministro.xsd”. Esquema respuesta operaciones (Alta y Anulación):](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaSuministro.xsd) <https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaSuministro.xsd>
      * [RespuestaConsultaLR.xsd. Esquema respuesta operaciones consulta.](https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaConsultaLR.xsd) <https://prewww2.aeat.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaConsultaLR.xsd>

      
## 8. Anexo I: Definición de servicios y esquemas (entorno de PRODUCCIÓN).

   Definición servicios y esquemas v1.0.

   1. ### Definición de servicios.

      Definición servicios (WSDL):

      <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SistemaFacturacion.wsdl>
   2. ### Esquemas de Entrada

      Esquemas mensajes entrada:

      * [“SuministroInformacion.xsd”. Definición tipos comunes:](https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroInformacion.xsd) <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroInformacion.xsd>
      * “SuministroLR.xsd”. Esquema operaciones (Alta y Anulación):

        <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/SuministroLR.xsd>
      * [ConsultaLR.xsd. Esquema operación consulta.](https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/ConsultaLR.xsd) <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/ConsultaLR.xsd>
   3. ### Esquemas de Salida.

      Esquemas mensajes respuesta:

      * [“RespuestaSuministro.xsd”. Esquema respuesta operaciones (Alta y Anulación):](https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaSuministro.xsd) <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaSuministro.xsd>
      * [RespuestaConsultaLR.xsd. Esquema respuesta operaciones consulta.](https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaConsultaLR.xsd) <https://www2.agenciatributaria.gob.es/static_files/common/internet/dep/aplicaciones/es/aeat/tikeV1.0/cont/ws/RespuestaConsultaLR.xsd>

      
## 9. Anexo II: Operativa de remisión voluntaria «VERIFACTU»

   1. ### Operativa: Alta de un registro de facturación.

      1. Alta inicial (“normal”) del registro de facturación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ALTA | · Alta inicial ("normal").<br>· Alta habitual. | · No informar `<Subsanacion>`/`<RechazoPrevio>` o valor N | Registro no debe existir en SIF/AEAT. | Alta registro con nuevos datos. |

         Registro de alta incluye huella (según especificaciones doc. huella AEAT). Encadenamiento con registro inmediatamente anterior por orden cronológico en SIF.

         1. #### Ejemplo mensaje XML de alta inicial (“normal”) del registro de facturación.

            Fichero XML de entrada:
            
			```xml
            <stripped/>
            ```
      2. Subsanación del registro de facturación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ALTA DE SUBSANACIÓN | · Subsanación registro ya generado/remitido.<br>· Subsanación habitual si no se exige factura rectificativa. | · `<Subsanacion>`=S<br>· No informar `<RechazoPrevio>` o valor N | Registro debe existir en SIF/AEAT. | Deja constancia de nuevos datos. |


         Para subsanar registro enviado ("Aceptado" o "AceptadoConErrores"), si no procede factura rectificativa o anulación, generar nuevo registro "de subsanación" con misma clave original y datos correctos, y remitirlo a AEAT. Registro original inalterado. Nuevo registro incluye huella y se encadena con el anterior cronológicamente en SIF.

         1. #### Ejemplo mensaje XML de subsanación del registro de facturación.

            Fichero XML de entrada:

            ```xml
            <stripped/>
            ```
            
      3. Alta, tras un rechazo previo del registro de facturación de alta inicial (y que, por tanto, no existe aún en la AEAT).

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ALTA POR RECHAZO | · Alta por rechazo de alta inicial (no existe en AEAT).<br>· Subsanación de datos de alta inicial, si no se exige factura rectificativa. | · `<Subsanacion>`=S<br>· `<RechazoPrevio>`=X | · Clave única registro no debe existir en AEAT.<br>· Alta previa fue rechazada. | Alta registro con nuevos datos. |

         Para subsanar registro de alta inicial rechazado (no existe en AEAT), si no procede factura rectificativa o anulación, generar nuevo registro “de subsanación” con datos correctos y enviarlo. Registro original inalterado. Nuevo registro incluye huella y se encadena con el anterior cronológicamente en SIF.

         1. ####  Ejemplo mensaje XML de alta, tras un rechazo previo del registro de facturación de alta inicial (y que, por tanto, no existe aún en la AEAT).

            Fichero XML de entrada:

           ```xml
			<stripped/>
			```

1. ### Operativa: Anulación de un registro de facturación.

   1. Anulación del registro de facturación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ANULACIÓN | · Anulación registro ya generado/remitido.<br>· Anulación habitual si no se exige factura rectificativa. | · No informar `<SinRegistroPrevio>`/`<RechazoPrevio>` o valor N | · Registro debe existir en SIF/AEAT.<br>· Registro a anular puede ser de alta o anulación. | Anula registro dejando nuevos datos. |

      Para operación incorrecta (casos excluidos de factura rectificativa), generar registro de anulación con misma clave original. El registro de anulación incluye huella y se encadena con el anterior cronológicamente en SIF.

      1. #### Ejemplo mensaje XML de anulación del registro de facturación.

         Fichero XML de entrada:

         ```xml
		<stripped/>
		 ```
   2. Anulación, tras un rechazo previo del registro de facturación de anulación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ANULACIÓN POR RECHAZO | · Anulación (tras rechazo previo) cuando registro a anular está en AEAT. | · No informar `<SinRegistroPrevio>` o valor N<br>· `<RechazoPrevio>`=S | · Clave única registro debe existir en AEAT.<br>· Anulación previa fue rechazada. | Anula registro dejando nuevos datos. |

      Para subsanar registro de anulación rechazado, generar nuevo registro “de subsanación de anulación por rechazo” con misma clave original y datos correctos, y remitirlo. Registro original inalterado. Nuevo registro incluye huella y se encadena con el anterior cronológicamente en SIF.

      1. ####  Ejemplo mensaje XML de anulación, tras un rechazo previo del registro de facturación de anulación.

         Fichero XML de entrada:

         ```xml
		<stripped/>
		```
   3. Anulación cuando el registro de facturación que se quiere anular NO está registrado en la AEAT.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ANULACIÓN SIN REGISTRO PREVIO | ·Anulación cuando registro a anular NO está en AEAT. | · `<SinRegistroPrevio>`=S<br>· No informar `<RechazoPrevio>` o valor N | ·Clave única registro no debe existir en AEAT. | Alta con estado anulado del registro. |

      Para anular registro no registrado en AEAT (ej. sistema no era verificable, o alta fue rechazada), generar nuevo registro de anulación sin registro previo y remitirlo. El registro de anulación incluye huella y se encadena con el anterior cronológicamente en SIF.

      1. ####  Ejemplo mensaje XML de anulación cuando el registro de facturación que se quiere anular NO está registrado en la AEAT.

         Fichero XML de entrada:
         
		```xml
         <stripped/>
 ```
2. ### Operativa habitual de remisión agrupada de registros de facturación.

   1. Ejemplo de mensaje XML que incluye tres registros de facturación (dos de alta y uno de anulación).

      Fichero XML de entrada con 3 registros:
      
		```xml
	      <stripped/>
		```

## 1. Anexo III: Operativa de remisión de registros de facturación para responder a un requerimiento de la AEAT «No VERIFACTU».

   Bajo requerimiento AEAT, obligado suministrará registros **conservados** vía sede electrónica.

   Registros enviados se dan de alta como nuevos en AEAT (sean alta o anulación).

   Validaciones de negocio no provocan rechazo, se marcan como errores admisibles. Solo validaciones de <NIF> o <IdOtro> provocan rechazo.

   No subsanar errores de negocio; enviar registros tal como se conservaron.

   Obligatorio en cabecera: <RefRequerimiento>. En último envío, marcar <FinRequerimiento>="S".

   1. ### Operativa: Alta de un registro de facturación.

      1. Alta inicial (“normal”) del registro de facturación.


		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ALTA | · Alta inicial ("normal").<br>· Alta habitual. | · No informar `<Subsanacion>`/`<RechazoPrevio>` o valor N | Registro no debe existir en SIF/AEAT. | Alta registro con nuevos datos. |

         Registro de alta incluye huella (según especificaciones doc. huella AEAT). Encadenamiento con registro inmediatamente anterior por orden cronológico en SIF.

         1. #### Ejemplo mensaje XML de alta inicial (“normal”) del registro de facturación.

            Fichero XML de entrada:


            ```xml
			<stripped/>
			```
      2. Subsanación del registro de facturación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ALTA DE SUBSANACIÓN | · Alta para subsanación de registro ya generado/remitido.<br>· Subsanación habitual si no se exige factura rectificativa. | · `<Subsanacion>`=S<br>· No informar `<RechazoPrevio>` o valor N | Registro debe existir en SIF/AEAT. | Deja constancia de nuevos datos. |

         Si se realizó subsanación en SIF (sin exigir factura rectificativa), se generó nuevo registro “de subsanación”. Este registro **conservado** debe ser enviado, sin modificar el original. No usar para subsanar errores de validación de negocio.

         1. #### Ejemplo mensaje XML de subsanación del registro de facturación.

            Fichero XML de entrada:
            
			```xml
            <stripped/>
            ```
   2. ### Operativa: Anulación de un registro de facturación.

      1. Anulación del registro de facturación.

		| Operación | Descripción | Operativa | Condiciones | Consecuencias |
		| :--- | :--- | :--- | :--- | :--- |
		| ANULACIÓN | · Anulación registro ya generado/remitido.<br>· Anulación habitual si no se exige factura rectificativa. | · No informar `<SinRegistroPrevio>`/`<RechazoPrevio>` o valor N | · Registro a anular puede ser de alta o anulación. | Crea nuevo registro, dejando ambos datos (anulación y alta). |

         Si se realizó anulación en SIF (sin exigir factura rectificativa), se generó nuevo registro “de anulación”. Este registro **conservado** debe ser enviado, sin modificar el original.

         1. #### Ejemplo mensaje XML de anulación del registro de facturación.

            Fichero XML de entrada:
            
			```xml
            <stripped/>
            ```
            
## 2. Anexo IV: Operativa de consulta de información presentada (servicio solo disponible en remisión voluntaria «VERIFACTU»)

   Consulta información presentada por emisor. Puede realizarla emisor o destinatario (solo remisión voluntaria «VERIFACTU»).

   1. ### Operativa: Consulta emisor para obtener registros presentados.

      1. Consulta registros presentados ordenados por fecha presentación

         Servicio responde con máx. 10.000 registros ordenados por fecha presentación.

         1. #### Ejemplo mensaje XML de consulta de registros de facturación presentados previamente. Consulta del emisor del registro de facturación.

            XML de entrada:
            
			```xml
            <stripped/>
            ```
         2. #### Ejemplo mensaje XML de consulta de registros de facturación presentados previamente filtrando por ejercicio, periodo y NIF de la contraparte. Consulta del emisor del registro de facturación.
			```xml
            <stripped/>
            ```
      2. Consulta del destinatario (cliente) para obtener los registros presentados por su proveedor.

         Destinatario puede consultar facturas de su proveedor.

         Si se superan 10.000 registros, realizar nuevas consultas paginadas con <ClavePaginacion>.

         1. #### Ejemplo mensaje XML de consulta paginada de registros de facturación presentados previamente. Consulta del destinatario del registro de facturación.

		XML de entrada:
		
		```xml
		<stripped/>
		```

---

# Especificaciones técnicas para generar huella/hash de registros de facturación


## Índice

1. [INTRODUCCIÓN 3](#bookmark0)
2. [ALGORITMO A UTILIZAR 4](#bookmark1)
3. [DATOS DE ENTRADA 5](#bookmark2)
4. [EJEMPLO TRATAMIENTO DATOS ENTRADA JAVA 8](#bookmark3)
5. [DATOS DE SALIDA 9](#bookmark4)
6. [EJEMPLOS 10](#bookmark5)

   1. [Caso 1: primer registro facturación (alta) en SIF](#bookmark6) [10](#bookmark6)
   2. [Caso 2: registro facturación (alta) con registro anterior en SIF (segundo o sucesivo)](#bookmark7) [11](#bookmark7)
   3. [Caso 3: registro facturación (anulación) con registro anterior en SIF (segundo o sucesivo)](#bookmark8) [12](#bookmark8)
7. [VALIDACIÓN 13](#bookmark9)

## 1. Introducción

   Este doc. proporciona detalles técnicos para implementar y cumplir especificaciones del **art. 13 “Huella o «hash» de los registros de facturación”** de la Orden XXXXXXX. Desarrolla especificaciones del reglamento sobre requisitos de sistemas de facturación y estandarización de formatos (Real Decreto 1007/2023) y del art. 6.5 del reglamento de obligaciones de facturación (Real Decreto 1619/2012).
   
## 2. Algoritmo a utilizar

   Algoritmo detallado en Lista L12, apdo. 6, anexo orden. A fecha publicación, único permitido:

   #### SHA-256.
   
## 3. Datos de entrada

   La huella o «hash» se realizará sobre los siguientes campos del XML (registros facturación/evento), en el orden enunciado, coincidente con su aparición en los diseños del anexo de la orden.

   Se distinguen tres subconjuntos de campos según tipo de registro:

   1. Campos para registros de facturación de alta (y su "ruta"):

      1. IDEmisorFactura (RegistroAlta/IDFactura/IDEmisorFactura)
      2. NumSerieFactura (RegistroAlta/IDFactura/NumSerieFactura)
      3. FechaExpedicionFactura (RegistroAlta/IDFactura/FechaExpedicionFactura)
      4. TipoFactura (RegistroAlta/TipoFactura)
      5. CuotaTotal (RegistroAlta/CuotaTotal)
      6. ImporteTotal (RegistroAlta/ImporteTotal)
      7. Huella (RegistroAlta/Encadenamiento/RegistroAnterior/Huella)
      8. FechaHoraHusoGenRegistro (RegistroAlta/FechaHoraHusoGenRegistro)

      
   2. Campos para registros de facturación de anulación (y su "ruta"):

      1. IDEmisorFacturaAnulada (RegistroAnulacion/IDFactura/IDEmisorFacturaAnulada)
      2. NumSerieFacturaAnulada (RegistroAnulacion/IDFactura/NumSerieFacturaAnulada)
      3. FechaExpedicionFacturaAnulada (RegistroAnulacion/IDFactura/FechaExpedicionFacturaAnulada)
      4. Huella (RegistroAnulacion/Encadenamiento/RegistroAnterior/Huella)
      5. FechaHoraHusoGenRegistro (RegistroAnulacion/FechaHoraHusoGenRegistro)

      
   3. Campos para registros de evento (y su "ruta"):

      1. NIF (RegistroEvento/Evento/SistemaInformatico/NIF)
      2. ID (RegistroEvento/Evento/SistemaInformatico/IDOtro/ID)
      3. IdSistemaInformatico (RegistroEvento/Evento/SistemaInformatico/IdSistemaInformatico)
      4. Version (RegistroEvento/Evento/SistemaInformatico/Version)
      5. NumeroInstalacion (RegistroEvento/Evento/SistemaInformatico/NumeroInstalacion)
      6. NIF (RegistroEvento/Evento/ObligadoEmision/NIF)
      7. TipoEvento (RegistroEvento/Evento/TipoEvento)
      8. HuellaEvento (RegistroEvento/Evento/Encadenamiento/EventoAnterior/HuellaEvento)
      9. FechaHoraHusoGenEvento (RegistroEvento/Evento/FechaHoraHusoGenEvento)

 Independiente del tipo de registro, los datos se concatenarán en el orden descrito en una única cadena ***String***, con la siguiente estructura:

 `nombreCampo1=valorCampo1&nombreCampo2=valorCampo2&nombreCampoN=valorCampoN`

 El **nombre del campo** es un valor constante, como se describe en el XML.

 Los **valores de los campos** deben ser los del XML, eliminando espacios iniciales/finales. En **campos numéricos**, valores con uno o dos decimales son indiferentes (ceros a la derecha no relevantes), siendo válidos para generar la huella.

 * Ej: si NumSerieFactura es `<NumSerieFactura> 12345678 / G33 </NumSerieFactura>`, el valor es “12345678 / G33”.
 * Ej: si ImporteTotal es `<ImporteTotal>123.1</ImporteTotal>`, se trata igual que `<ImporteTotal>123.10</ImporteTotal>`.

   Si el campo no aparece o no tiene valor, en la cadena solo se pondrá el nombre del campo y “=” (sin valor), ej:
 * Primer registro, sin huella "anterior": 
 …ImporteTotal=123.45&**Huella**=&FechaHoraHusoGenRegistro=…
 * Se informa NIF pero no ID en registro de evento (son excluyentes): NIF=89890001K&**ID**=&IdSistemaInformatico=…

   La cadena se codificará en un array de bytes formato

   #### UTF-8 como entrada para el algoritmo de huella o «hash».
   
## 4. Ejemplo tratamiento de datos de entrada en lenguaje Java

   Ejemplo de tratamiento de datos de entrada para registro de alta en Java.

``` java
import java.io.UnsupportedEncodingException;
import java.net.URLEncoder;
import java.util.Date;

// NOTE: This code assumes the existence of an external 'Base16' class
// and a 'formatea(Date)' method, which were not provided.

public class GeneradorHuella {

    /**
     * Generates a SHA-256 hash for a given message.
     */
    public static String getHashVerifactu(String msg) {
        try {
            java.security.MessageDigest digest = java.security.MessageDigest.getInstance("SHA-256");
            // Assuming Base16 is a custom or library class for hex encoding
            // return new Base16(false).encodeAsString(digest.digest(msg.getBytes(java.nio.charset.StandardCharsets.UTF_8)));
            // Using a standard alternative for demonstration:
            return bytesToHex(digest.digest(msg.getBytes(java.nio.charset.StandardCharsets.UTF_8)));
        } catch (Exception e) {
            throw new IllegalArgumentException("Error al generar la huella SHA", e);
        }
    }

    /**
     * Constructs the reference string for a new registration record.
     */
    public static String getReferenciaRegistroAlta(String nifEmisor, String numFacturaSerie, String fechaExpedicion,
                                                    String tipoFactura, String cuotaTotal, String importeTotal,
                                                    String huellaAnterior, String fechaHoraUsoRegistro) {
        StringBuilder sb = new StringBuilder();
        return sb.append(getValorCampo("IDEmisorFactura", nifEmisor, true))
                .append(getValorCampo("NumSerieFactura", numFacturaSerie, true))
                .append(getValorCampo("FechaExpedicionFactura", fechaExpedicion, true))
                .append(getValorCampo("TipoFactura", tipoFactura, true))
                .append(getValorCampo("CuotaTotal", cuotaTotal, true))
                .append(getValorCampo("ImporteTotal", importeTotal, true))
                .append(getValorCampo("Huella", huellaAnterior, true))
                .append(getValorCampo("FechaHoraHusoGenRegistro", fechaHoraUsoRegistro, false))
                .toString();
    }

    /**
     * Formats a key-value pair for the reference string.
     */
    public static String getValorCampo(String nombre, String valor, boolean separador) {
        String campo = nombre + "=" + ((valor == null) ? "" : valor.trim());
        if (separador) {
            return campo + "&";
        } else {
            return campo;
        }
    }

    /**
     * Formats and URL-encodes a key-value pair.
     */
    public static String getValorCampoEncoded(String nombre, String valor, boolean separador)
            throws UnsupportedEncodingException {
        String campo = nombre + "=" + URLEncoder.encode(valor, "UTF-8");
        if (separador) {
            return campo + "&";
        } else {
            return campo;
        }
    }

    /**
     * Calculates the complete hash for a new registration record.
     */
    public static String calcularHuellaAlta(String nifEmisor, String numFacturaSerie, Date fechaExpedicion,
                                            String tipoFactura, String cuotaTotal, String importeTotal,
                                            String huellaAnterior, String fechaHoraUsoRegistro) {
        // Assuming 'formatea(Date)' is a method that converts Date to the required String format
        String ref = getReferenciaRegistroAlta(nifEmisor, numFacturaSerie, formatea(fechaExpedicion), tipoFactura,
                cuotaTotal, importeTotal, huellaAnterior, fechaHoraUsoRegistro);
        return getHashVerifactu(ref);
    }

    // Helper method to stand in for the missing Base16 class
    private static String bytesToHex(byte[] hash) {
        StringBuilder hexString = new StringBuilder(2 * hash.length);
        for (byte b : hash) {
            String hex = Integer.toHexString(0xff & b);
            if (hex.length() == 1) {
                hexString.append('0');
            }
            hexString.append(hex);
        }
        return hexString.toString();
    }
    
    // Placeholder for the missing formatea method
    private static String formatea(Date date) {
        // Implement date formatting logic here, e.g., "dd-MM-yyyy"
        return new java.text.SimpleDateFormat("dd-MM-yyyy").format(date);
    }
}
```

## 5. Datos de salida

   Se aplicará el algoritmo de huella/«hash» a la cadena generada con los datos del XML del registro.

   Formato de salida:

   * En sistema **hexadecimal**.
   * En **mayúsculas**.
   * Tamaño de **64 caracteres alfanuméricos**.

   El resultado del algoritmo se informará en el siguiente campo del registro (facturación o evento), según el tipo:

   1. Campo para huella/«hash» en registros de alta (y su "ruta"):

      * #### Huella (RegistroAlta/Huella)
   2. Campo para huella/«hash» en registros de anulación (y su "ruta"):

      * #### Huella (RegistroAnulacion/Huella)
   3. Campo para huella/«hash» en registros de evento (y su "ruta"):
   * #### HuellaEvento (RegistroEvento/Evento/HuellaEvento)

   La huella calculada siempre debe informarse en su campo correspondiente. Incluso en el **primer registro** de facturación/evento (donde “**PrimerRegistro**”/“**PrimerEvento**” es “**S**” y no se informan bloques “RegistroAnterior”/“EventoAnterior”), es necesario generar e incluir los campos **Huella** o **HuellaEvento**. Ver punto 6. Ejemplos.
   
## 6. Ejemplos

   Tres ejemplos de registros de facturación.

   1. ### Caso 1: primer registro de facturación (alta) en un SIF

      **Datos de entrada** XML:

      1. IDEmisorFactura: **89890001K**
      2. NumSerieFactura: **12345678/G33**
      3. FechaExpedicionFactura: **01-01-2024**
      4. TipoFactura: **F1**
      5. CuotaTotal: **12.35**
      6. ImporteTotal: **123.45**
      7. Huella (\*):
      8. FechaHoraHusoGenRegistro: **2024-01-01T19:20:30+01:00**

      (\*) Sin contenido, por ser el primer registro del SIF, sin registro anterior.

      Cadena resultante para aplicar el algoritmo de huella/«hash»:

      `IDEmisorFactura=89890001K&NumSerieFactura=12345678/G33&FechaExpedicionFactura=01-01- 2024&TipoFactura=F1&CuotaTotal=12.35&ImporteTotal=123.45&Huella=&Fec haHoraHusoGenRegistro=2024-01-01T19:20:30+01:00`

      Aplicando el algoritmo de huella/«hash» a los siguientes datos:

      `calcularHuella("IDEmisorFactura=89890001K&NumSerieFactura=12345678/G3
3&FechaExpedicionFactura=01-01-
2024&TipoFactura=F1&CuotaTotal=12.35&ImporteTotal=123.45&Huella=&Fec
haHoraHusoGenRegistro=2024-01-01T19:20:30+01:00”);`

      Dato de salida (huella/«hash»):
      
		`3C464DAF61ACB827C65FDA19F352A4E3BDC2C640E9E9FC4CC058073F38F12F60`

   2. ### Caso 2: registro de facturación (alta) con registro anterior en SIF (segundo o sucesivo)

      **Datos de entrada** XML:

      1. IDEmisorFactura: **89890001K**
      2. NumSerieFactura: **12345679/G34**
      3. FechaExpedicionFactura: **01-01-2024**
      4. TipoFactura: **F1**
      5. CuotaTotal: **12.35**
      6. ImporteTotal: **123.45**
      7. Huella:

         `3C464DAF61ACB827C65FDA19F352A4E3BDC2C640E9E9FC4CC058073F38F12F60`

      8. FechaHoraHusoGenRegistro: **2024-01-01T19:20:35+01:00**

      Cadena resultante para aplicar el algoritmo de huella/«hash»:

      `IDEmisorFactura=89890001K&NumSerieFactura=12345679/G34&FechaExpedicionFactura=01-01- 2024&TipoFactura=F1&CuotaTotal=12.35&ImporteTotal=123.45&Huella=3C464DAF61ACB827C65FDA19F352A4E3BDC2C640E9E9FC4CC058073F38F12F60&FechaHoraHusoGenRegistro=2024-01-01T19:20:35+01:00`

      Aplicando el algoritmo de huella/«hash» a los siguientes datos:

      `calcularHuella("IDEmisorFactura=89890001K&NumSerieFactura=12345679/G3 4&FechaExpedicionFactura=01-01-2024&TipoFactura=F1&CuotaTotal=12.35&ImporteTotal=123.45&Huella=3C464DAF61ACB827C65FDA19F352A4E3BDC2C640E9E9FC4CC058073F38F12F60&FechaHoraHusoGenRegistro=2024-01-01T19:20:35+01:00”);`

      Dato de salida (huella/«hash»):

      `F7B94CFD8924EDFF273501B01EE5153E4CE8F259766F88CF6ACB8935802A2B97`
      
   3. ### Caso 3: registro de facturación (anulación) con registro anterior en SIF (segundo o sucesivo)

      **Datos de entrada** XML:

      1. IDEmisorFacturaAnulada: **89890001K**
      2. NumSerieFacturaAnulada: **12345679/G34**
      3. FechaExpedicionFacturaAnulada: **01-01-2024**
      4. Huella:

         `F7B94CFD8924EDFF273501B01EE5153E4CE8F259766F88CF6ACB8935802A2B97`
         
      5. FechaHoraHusoGenRegistro: **2024-01-01T19:20:40+01:00**

      Cadena resultante para aplicar el algoritmo de huella/«hash»:

      `IDEmisorFacturaAnulada=89890001K&NumSerieFacturaAnulada=12345679/G
34&FechaExpedicionFacturaAnulada=01-01-2024&Huella=F7B94CFD8924EDFF273501B01EE5153E4CE8F259766F88CF
6ACB8935802A2B97&FechaHoraHusoGenRegistro=2024-01-01T19:20:40+01:00`

      Aplicando el algoritmo de huella/«hash» a los siguientes datos:

		`calcularHuella(“IDEmisorFacturaAnulada=89890001K&NumSerieFacturaAnulada=12345679G34&FechaExpedicionFacturaAnulada=01-01-2024&Huella=F7B94CFD8924EDFF273501B01EE5153E4CE8F259766F88CF6ACB8935802A2B97&FechaHoraHusoGenRegistro=2024-01-01T19:20:40+01:00”);`

      Dato de salida (huella/«hash»):

      `177547C0D57AC74748561D054A9CEC14B4C4EA23D1BEFD6F2E69E3A388F90C68`
      
## 7. Validación

El sistema de facturación debe asegurar que la huella/«hash» generada cumpla las especificaciones y formato detallados para los registros de facturación y evento.

Si en una remisión «VERIFACTU» la huella no coincide con el cálculo de la AEAT, el registro se marcará como “**Aceptado con errores**”.

---
---

# Especificaciones técnicas QR y URL

## 2. Especificaciones del código «QR».

*   **Tamaño:** 30x30 a 40x40 mm.
*   **Norma:** ISO/IEC 18004:2015.
*   **Corrección errores:** Nivel M (medio).
*   **Contenido:**
    a) «URL» del servicio de cotejo/remisión.
    b) Info. factura en la «URL»:
        1.º NIF expedidor.
        2.º N.º serie y n.º factura.
        3.º Fecha expedición.
        4.º Importe total.
*   **Facturas «VERI*FACTU»:** Deben incluir la frase «Factura verificable en la sede electrónica de la AEAT» o «VERI*FACTU».

---

## 3. Ubicación y presentación del código «QR».

*   **Contraste:** Alto entre «QR» y fondo.
*   **Margen:** Mín. 2 mm de espacio vacío (recomendado 6 mm).
*   **Posición:** Inicio factura, preeminente, 1ª pág.
    *   **Vertical:** Arriba (centrado o izq.-superior).
    *   **Horizontal:** Izquierda (sup.-izquierdo o centrado verticalmente).
*   **Texto precedente:** Siempre "QR tributario:", encima del código.
*   **Texto inferior (sólo «VERI*FACTU»):** Debajo del código, «Factura verificable en la sede electrónica de la AEAT» o «VERI*FACTU».

---

## 4. Consideraciones «URL» del código «QR».

Los parámetros de la «URL» deben codificarse con «URL encoding» (UTF-8). Cadenas de texto solo con caracteres ASCII 32-126.

**Ejemplo parámetros:**
*   URL base: `https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?`
*   nif: `89890001K`
*   numserie: `12345678&G33`
*   fecha: `01-01-2024`
*   importe: `241.4`

**URL codificada (correcta):**
`https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?nif=89890001K&numserie=12345678%26G33&fecha=01-01-2024&importe=241.4`

**URL sin codificar (errónea):**
`https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?nif=89890001K&numserie=12345678&G33&fecha=01-01-2024&importe=241.4`

### 4.1. Ejemplo «URL encoding» en java

```java
public static void main(String[] args) throws Exception {
    System.out.println(codificarQR("https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?", "89890001K", "12345678&G33", "01-01-2024", "241.40"));
}

public static String codificarQR(String prefijo, String nif, String numSerie, String fecha, String importe) {
    return new StringBuilder(prefijo)
        .append("nif=").append(encodeParam(nif)).append("&")
        .append("numserie=").append(encodeParam(numSerie)).append("&")
        .append("fecha=").append(encodeParam(fecha)).append("&")
        .append("importe=").append(encodeParam(importe))
        .toString();
}

public static String encodeParam(String param) {
    try {
        return java.net.URLEncoder.encode(param, "UTF-8");
    } catch (Exception e) {
        throw new RuntimeException(String.format("Error al codificar parametro %s", param));
    }
}
```

---

## 5. Formato «URL» del código «QR».

### 5.1. Sistema emite facturas verificables

*   **Pruebas:**
    `https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?nif=...&numserie=...&fecha=...&importe=...`
*   **Producción:**
    `https://www2.agenciatributaria.gob.es/wlpl/TIKE-CONT/ValidarQR?nif=...&numserie=...&fecha=...&importe=...`

### 5.2. Sistema emite facturas no verificables

*   **Pruebas:**
    `https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQRNoVerifactu?nif=...&numserie=...&fecha=...&importe=...`
*   **Producción:**
    `https://www2.agenciatributaria.gob.es/wlpl/TIKE-CONT/ValidarQRNoVerifactu?nif=...&numserie=...&fecha=...&importe=...`

---

## 6. Parámetros «URL» del código «QR».

4 parámetros **obligatorios**. Respuesta por defecto en “html”.

| Parámetro | Formato | Longitud | Obligatorio | Descripción |
| :--- | :--- | :--- | :--- | :--- |
| **nif** | Formato NIF | 9 | Sí | NIF del expedidor |
| **numserie** | Cadena texto (ASCII 32-126) | Máx. 60 | Sí | N° Serie + N° Factura |
| **fecha** | DD-MM-AAAA | 10 | Sí | Fecha expedición |
| **importe** | Numérico, separador "." | Máx. 12.2 | Sí | Importe total |

---

## 7. Parámetro opcional del servicio.

Admite un 5º parámetro opcional (**nunca en la «URL» del «QR»**).

| Parámetro | Formato | Valores | Obligatorio | Observaciones |
| :--- | :--- | :--- | :--- | :--- |
| **formato** | Alfanumérico | json | No | Respuesta en formato máquina (json). |

---

## 8. Ejemplos «URL» de código «QR» válidas.

### 8.1 Pruebas SIF verificable.

`https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQR?nif=89890001K&numserie=12345678-G33&fecha=01-09-2024&importe=241.4`

### 8.2 Pruebas SIF no verificable.

`https://prewww2.aeat.es/wlpl/TIKE-CONT/ValidarQRNoVerifactu?nif=89890001K&numserie=12345678-G33&fecha=01-09-2024&importe=241.4`

### 8.3 Producción SIF verificable.

`https://www2.agenciatributaria.gob.es/wlpl/TIKE-CONT/ValidarQR?nif=89890001K&numserie=12345678-G33&fecha=01-09-2024&importe=241.4`

### 8.4 Producción SIF no verificable.

`https://www2.agenciatributaria.gob.es/wlpl/TIKE-CONT/ValidarQRNoVerifactu?nif=89890001K&numserie=12345678-G33&fecha=01-09-2024&importe=241.4`

---

## 9. Ejemplos de respuestas.

### 9.1. Respuestas OK (Sistema verificable).

#### 9.1.1. Factura encontrada.

##### 9.1.1.1. Respuesta html/web.

> **Factura encontrada**
> En la Agencia Tributaria consta una factura con idénticas características...

##### 9.1.1.2. Respuesta json.

```json
{
    "status": "OK",
    "mensaje": "Factura encontrada",
    "respuesta": {
        "resultado": "00",
        "nif": "89890001K",
        "numserie": "12345678-G33",
        "fecha": "01-09-2024",
        "importe": "241.40"
    }
}
```

#### 9.1.2. Factura no encontrada.

##### 9.1.2.1. Respuesta html/web.

> **! Factura no encontrada**
> En la Agencia Tributaria no consta ninguna factura con las características remitidas...

##### 9.1.2.2. Respuesta json.

```json
{
    "status": "OK",
    "mensaje": "Factura no encontrada",
    "respuesta": {
        "resultado": "01",
        "nif": "89890001K",
        "numserie": "12345678-G33",
        "fecha": "01-09-2024",
        "importe": "241.50"
    }
}
```

### 9.2. Respuestas OK (Sistema no verificable).

#### 9.2.1. Respuesta html/web.

> **Factura no verificable**
> Esta factura ha sido expedida por un sistema informático de facturación que emite facturas no verificables...

#### 9.2.2. Respuesta json.

```json
{
    "status": "OK",
    "mensaje": "Factura no verificable",
    "respuesta": {
        "resultado": "02",
        "nif": "89890001K",
        "numserie": "12345678-G33",
        "fecha": "01-09-2024",
        "importe": "241.40"
    }
}
```

### 9.3. Respuestas incorrectas (KO).

#### 9.3.1. Error falta de parámetros.

##### 9.3.1.1. Respuesta html/web.

> **Alertas**
> ERROR: No se ha remitido el parámetro: fecha...
> ERROR: No se ha remitido el parámetro: importe...

##### 9.3.1.2. Respuesta json.

```json
{
    "status": "KO",
    "mensaje": "No se ha remitido el parámetro: fecha (...).No se ha remitido el parámetro: importe (...)",
    "visible": "S",
    "crashlytics": "N",
    "codigo_error": "1003.1004"
}
```

#### 9.3.2. Error en formato de campo.

##### 9.3.2.1. Respuesta html/web (ej. `importe=7,2`).

> **Alertas**
> ERROR: El importe tiene un formato incorrecto

##### 9.3.2.2. Respuesta json.

```json
{
    "status": "KO",
    "mensaje": "El importe tiene un formato incorrecto",
    "visible": "S",
    "crashlytics": "N",
    "codigo_error": "2005"
}
```

#### 9.3.3. Error en formato de NIF/NIE.

##### 9.3.3.1. Respuesta html/web (ej. `nif=891K`).

> **Alertas**
> ERROR: El NIF tiene un formato erróneo o no es válido

##### 9.3.3.2. Respuesta json.

```json
{
    "status": "KO",
    "mensaje": "El NIF tiene un formato erróneo o no es válido",
    "visible": "S",
    "crashlytics": "N",
    "codigo_error": "2001"
}
```

---

## 10. Listado de códigos de error de validación «URL».

| CÓDIGO | DESCRIPCIÓN |
| :--- | :--- |
| **1001** | Falta parámetro: nif |
| **1002** | Falta parámetro: numserie |
| **1003** | Falta parámetro: fecha |
| **1004** | Falta parámetro: importe |
| **2001** | NIF formato erróneo o inválido |
| **2002** | N.º serie excede máx. caracteres |
| **2003** | N.º serie contiene caracteres no permitidos |
| **2004** | Fecha expedición formato inválido (debe ser DD-MM-AAAA) |
| **2005** | Importe formato incorrecto |
| **2006** | Importe excede máx. caracteres |
| **3001** | Error técnico sistemas AEAT, reintente más tarde |
| **3002** | Excedido n.º máx. intentos/día, acceso bloqueado |

---

## 12. Anexo (ejemplos de «QR»).

a) Verificable, vertical (57mm), QR 40x40, frase larga.
b) Verificable, vertical (57mm), QR 40x40, frase corta («VERI*FACTU»).
c) Verificable, vertical (44mm), QR 40x40, frase larga.
d) Verificable, vertical (57mm), QR 30x30, frase larga.
e) Verificable, horizontal (140mm), QR 40x40, frase larga.
f) No verificable, vertical (57mm), QR 40x40.
g) No verificable, horizontal (140mm), QR 40x40.
h) Verificable, vertical (A4), QR 40x40, centrado.
i) Verificable, vertical (A4), QR 40x40, centrado con contenido a los lados.
j) Verificable, vertical (A4), QR 40x40, a la izquierda con contenido a la derecha.
k) Verificable, vertical (A4), QR 40x40, a la derecha con contenido a la izquierda.
l) Verificable, horizontal (A4), QR 40x40.