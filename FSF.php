/* (FSF) Find String in your Files 
/* Upload this file, and use de UI to search text strings in files in your server.

<form method="GET">
  <p>
    <input name="search" placeholder="Enter query" autocomplete="off">
  </p>

  <input type="submit" name="submit">
</form>

<?php

function get_directory_content($directory)
{
  global $search, $results;

  $files = scandir($directory);
  foreach ($files as $file)
  {
    if ($file == "." || $file == "..")
    {
      continue;
    }

    $is_file = false;
    $path = realpath($directory . DIRECTORY_SEPARATOR . $file);

    if (is_dir($path))
    {
      get_directory_content($path);
      $is_file = true;
    }
    else
    {
      $is_file = true;
    }

    if ($is_file)
    {
      $content = file_get_contents($path);

      if (stripos($content, $search) !== false)
      {
        // Laravel, \stdClass()
        $obj = new stdClass();
        $obj->file_name = $file;
        $obj->path = $path;

        $lines = array();
        $line_number = 0;

        $file_handler = fopen($path, "r");
        while ( ( $line = fgets($file_handler, 4096) ) !== false )
        {
          $line_number++;

          if (stripos($line, $search) !== false)
          {
            array_push($lines, $line_number);
          }
        }

        $obj->lines = $lines;

        array_push($results, $obj);
      }
    }
  }
}

if (isset($_GET["submit"]))
{
  $search = $_GET["search"];
  $results = array();

  // Laravel, base_path()
  get_directory_content(dirname(__FILE__));
  
  foreach ($results as $result)
  {
    ?>

    <div>
        <h1>
            <?php echo $result->path; ?>
        </h1>

        <h2>Lines</h2>
        <ul>
          <?php foreach ($result->lines as $line) { ?>
              <li>
                  <?php echo $line; ?>
              </li>
          <?php } ?>
        </ul>
    </div>

    <?php
  }
}

/* PT - Faça o upload desse arquivo na pasta onde estão os arquivos em que deseja fazer a busca por "string" em seu servidor e utilize o campo de busca para encontrar todos os arquivos que contenham a "string de busca" em seu servidor web */
/* @mlvpcwb
