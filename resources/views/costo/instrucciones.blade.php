<div class="space-y-6 text-sm leading-relaxed text-gray-800 dark:text-gray-100" 
     x-data="{ modalOpen: false, modalImg: '' }">

    <!-- Introducción -->
    <p class="text-lg font-bold flex items-center gap-2">
        ℹ️ Manual de Usuario: Formulario de Registro y Costos de Alimentos
    </p>
    <p>
        Este manual explica cómo diligenciar correctamente el formulario 
        <strong>Registro de alimentos</strong> en el sistema <strong>PANYC</strong>.  
        Aquí aprenderás a registrar alimentos, consultar precios activos, 
        y actualizar valores con su respectiva unidad de medida.
    </p>

    <!-- Imagen general -->
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/image.png') }}" 
             alt="Formulario general" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Aquí irá una imagen general del formulario.
        </em>
    </div>

    <!-- Selección de alimento -->
    <p class="text-base font-semibold flex items-center gap-1 mt-6">
        🔍 1. Selección de Alimento
    </p>
    <p>
        En esta sección puedes <strong>buscar y seleccionar un alimento</strong> 
        por su nombre o código.  
        El sistema te mostrará si tiene un precio activo (✅) o no (❌).
    </p>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/image1.png') }}" 
             alt="Selección de alimento" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen de la sección de búsqueda de alimento.
        </em>
    </div>

    <!-- Precio actual -->
    <p class="text-base font-semibold flex items-center gap-1 mt-6">
        💲 2. Precio Activo del Alimento
    </p>
    <p>
        Aquí se muestra el <strong>precio vigente</strong> del alimento 
        junto con la <strong>fecha de la última actualización</strong>.  
        Si no existe un precio activo, se indicará en pantalla.
    </p>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center space-y-3">
        <img src="{{ asset('img/manual/image2.png') }}" 
             alt="Precio actual" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <img src="{{ asset('img/manual/image6.png') }}" 
             alt="Precio actual detalle" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen del campo que muestra el precio actual y la fecha.
        </em>
    </div>

    <!-- Registro de nuevo precio -->
    <p class="text-base font-semibold flex items-center gap-1 mt-6">
        ✏️ 3. Registro de un Nuevo Precio
    </p>
    <p>
        Cuando necesites <strong>actualizar el valor</strong> de un alimento, 
        utiliza esta sección.  
        Debes ingresar el nuevo precio en pesos colombianos y seleccionar 
        la <strong>unidad de medida</strong> adecuada.
    </p>
    <ul class="list-disc pl-5">
        <li><strong>Nuevo precio:</strong> Valor en pesos (ejemplo: <code>3500</code>).</li>
        <li><strong>Unidad de medida:</strong> Kilogramos, gramos, litros, mililitros o unidad.</li>
        <li>El sistema desactiva automáticamente el precio anterior y marca el nuevo como activo.</li>
    </ul>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/image3.png') }}" 
             alt="Nuevo precio" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen del formulario de registro del nuevo precio.
        </em>
    </div>

    <!-- Recomendaciones -->
    <p class="text-base font-semibold flex items-center gap-1 mt-6">
        ⚠️ 4. Recomendaciones Generales
    </p>
    <ul class="list-disc pl-5">
        <li>Revisa siempre que los campos no queden vacíos.</li>
        <li>Usa unidades correctas (<code>g</code>, <code>kg</code>, <code>ml</code>, <code>l</code>, <code>unidad</code>).</li>
        <li>Verifica el precio y la unidad antes de guardar.</li>
        <li>Solo habrá <strong>un precio activo</strong> por alimento.</li>
    </ul>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center space-y-3">
        <img src="{{ asset('img/manual/image4.png') }}" 
             alt="Ejemplo correcto" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <img src="{{ asset('img/manual/image5.png') }}" 
             alt="Ejemplo incorrecto" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen de ejemplo con precios correctos y errores comunes.
        </em>
    </div>

    <!-- Modal -->
    <template x-if="modalOpen">
        <div class="fixed inset-0 z-50 bg-black bg-opacity-80 flex items-center justify-center">
            <div class="relative">
                <button @click="modalOpen = false" 
                        class="absolute top-2 right-2 text-white text-2xl font-bold">✖</button>
                <img :src="modalImg" alt="Imagen ampliada" 
                     class="max-h-screen max-w-screen rounded-lg shadow-lg">
            </div>
        </div>
    </template>

</div>
