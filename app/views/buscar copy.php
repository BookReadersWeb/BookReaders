<?php

$editions = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query']) && !empty($_POST['query'])) {
    $query = urlencode($_POST['query']);
    $url = "https://openlibrary.org/search.json?q=$query&mode=everything";
    
    $json = @file_get_contents($url);

    if ($json !== false) {
        $data = json_decode($json, true);

        if ($data && isset($data['docs']) && !empty($data['docs'])) {
            $books = $data['docs'];
            
            // Iterar sobre todos los libros para obtener sus ediciones
            foreach ($books as $book) {
                if(isset($book['key'])){
                    $key = str_replace('/works/', '', $book['key']);
                    $edition_url = "https://openlibrary.org/works/$key/editions.json";
                    $edition_json = @file_get_contents($edition_url);

                    if ($edition_json !== false) {
                        $edition_data = json_decode($edition_json, true);
                        // Agregar las ediciones al arreglo de ediciones
                        if (isset($edition_data['entries'])) {
                            foreach ($edition_data['entries'] as $entry) {
                                $entry['author_name'] = isset($book['author_name']) ? $book['author_name'] : 'N/A';
                                $editions[] = $entry;
                            }
                        }
                    }
                }
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Libros</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-slate-400 font-sans">

<div class="container mx-auto px-4 py-8">

    <h1 class="text-3xl font-bold mb-8">Buscador de Libros</h1>
    
    <form action="" method="POST" class="mb-8">
        <div class="flex items-center">
            <input type="text" id="query" name="query" placeholder="Ingrese el título del libro" class="flex-grow border rounded-l py-2 px-4 mr-2 focus:outline-none focus:border-blue-400" value="<?= isset($_POST['query']) ? $_POST['query'] : '' ?>">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-r hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Buscar</button>
        </div>
    </form>

    <?php if (!empty($editions)): ?>
        <div class="grid grid-cols-1 gap-8">
            <?php foreach ($editions as $edition): ?>
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-semibold mb-4"><?= isset($edition['title']) ? $edition['title'] : 'N/A' ?></h2>
                    <p class="text-gray-700 mb-2"><strong>Autor(es):</strong> <?= isset($edition['author_name']) ? (is_array($edition['author_name']) ? implode(', ', $edition['author_name']) : $edition['author_name']) : 'N/A' ?></p>
                    <p class="text-gray-700 mb-2"><strong>Fecha de Publicación:</strong> <?= isset($edition['publish_date']) ? implode(', ', (array)$edition['publish_date']) : 'N/A' ?></p>
                    
                    <?php if (isset($edition['covers']) && !empty($edition['covers'])): ?>
                        <?php $cover_id = $edition['covers'][0]; ?>
                        <p class="text-gray-700 mb-2"><strong>ID de Portada:</strong> <?= $cover_id ?></p>
                        <img src="https://covers.openlibrary.org/b/id/<?= $cover_id ?>-M.jpg" alt="Portada del libro" class="mx-auto mb-4">
                    <?php else: ?>
                        <p class="text-gray-500 italic text-center">Portada no disponible</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p class="text-gray-700">No se encontraron resultados para la búsqueda.</p>
    <?php endif; ?>

</div>

</body>
</html>
