<div class="space-y-6 text-sm leading-relaxed text-gray-800 dark:text-gray-100"
     x-data="{ modalOpen: false, modalImg: '' }">

    <!-- ¿Qué es este formulario? -->
    <p class="text-base font-semibold flex items-center gap-2">
        ℹ️ ¿Qué es este formulario?
    </p>
    <p>
        El formulario <strong>“Registro de alimentos”</strong> permite ingresar alimentos nuevos o ya existentes al sistema <strong>PANYC</strong>, incluyendo su información básica, grupo alimenticio, fuente de datos y composición nutricional.
    </p>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/que-es.png') }}" 
             alt="Qué es este formulario" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen ilustrativa de la sección "¿Qué es este formulario?".
        </em>
    </div>

    <!-- ¿Cuándo debo usarlo? -->
    <p class="text-base font-semibold flex items-center gap-2 mt-6">
        📅 ¿Cuándo debo usarlo?
    </p>
    <ul class="list-disc pl-5">
        <li>Para registrar un <strong>alimento nuevo</strong> que no existe en la base de datos.</li>
        <li>Para agregar un <strong>alimento existente</strong> con un código manual propio.</li>
    </ul>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/cuando-usar.png') }}" 
             alt="Cuándo usar el formulario" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Ejemplo de cuándo utilizar el formulario.
        </em>
    </div>

    <!-- Instrucciones -->
    <p class="text-base font-semibold flex items-center gap-2 mt-6">
        ✏️ Instrucciones para diligenciar el formulario
    </p>
    <ul class="list-disc pl-5">
        <li><strong>Identificación:</strong> Selecciona si el alimento es nuevo o ya está en la base.</li>
        <li><strong>Información general:</strong> Código, nombre, parte comestible, fuente y grupo.</li>
        <li><strong>Composición nutricional:</strong> Humedad, energía, proteína, lípidos, carbohidratos, fibra, cenizas.</li>
        <li><strong>Minerales:</strong> Calcio, hierro, sodio, fósforo, yodo, zinc, magnesio, potasio.</li>
        <li><strong>Vitaminas:</strong> Tiamina, riboflavina, niacina, folatos, B12, C, A.</li>
        <li><strong>Grasas y colesterol:</strong> Saturadas, monoinsaturadas, poliinsaturadas y colesterol.</li>
    </ul>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/instrucciones.png') }}" 
             alt="Instrucciones formulario" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Imagen explicativa de las instrucciones.
        </em>
    </div>

    <!-- Recomendaciones -->
    <p class="text-base font-semibold flex items-center gap-2 mt-6">
        ⚠️ Recomendaciones generales
    </p>
    <ul class="list-disc pl-5">
        <li>Evita dejar campos importantes vacíos.</li>
        <li>Usa unidades correctas como: <code>g</code>, <code>mg</code>, <code>%</code>, <code>kcal</code>, etc.</li>
        <li>Verifica los datos antes de guardar el registro.</li>
    </ul>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/recomendaciones.png') }}" 
             alt="Recomendaciones formulario" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Recomendaciones visuales para el formulario.
        </em>
    </div>

    <!-- Código automático -->
    <p class="text-base font-semibold flex items-center gap-2 mt-6">
        #️⃣ Ejemplo de código automático
    </p>
    <p>
        Si marcas un alimento como nuevo, se generará un código automático como: 
        <code class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-1 rounded">TE043</code>.
    </p>
    <div class="bg-gray-100 dark:bg-gray-800 p-3 rounded text-center">
        <img src="{{ asset('img/manual/codigo.png') }}" 
             alt="Código automático ejemplo" 
             class="mx-auto rounded-lg shadow-md max-w-full h-auto cursor-pointer hover:opacity-80 transition"
             @click="modalOpen = true; modalImg = $event.target.src">
        <em class="block mt-2 text-gray-600 dark:text-gray-400">
            Ejemplo de un código generado automáticamente.
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
