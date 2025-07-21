<?php



// function validateTitlesUpload($excel_file_path, $expectedTitles, $page = 0){
//     $validation = false;
//     $reader = ReaderEntityFactory::createReaderFromFile($excel_file_path);
//     $reader->open($excel_file_path);
//     $titles = null;
//     $currentSheetIndex = 0;

//     foreach ($reader->getSheetIterator() as $sheet) {
//         if ($currentSheetIndex === $page) {
//             foreach ($sheet->getRowIterator() as $row) {
//                 $titles = $row->toArray();
//                 break;
//             }
//             break;
//         }
//         $currentSheetIndex++;
//     }

//     $reader->close();
//     $cleanedTitles = [];
//     $search = ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ü', 'Ñ', '%',"\r\n", "\r", "\n"];
//     $replace = ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'U', 'N', '',' ',' ',' '];

//     foreach ($titles as $title) {
//         $modifiedTitle = str_replace($search, $replace, trim($title));
//         if ($modifiedTitle !== '') {
//             $cleanedTitles[] = trim($modifiedTitle);
//         }
//     }

//     $difference1 = array_diff($cleanedTitles, $expectedTitles);
//     $difference2 = array_diff($expectedTitles, $cleanedTitles);

//     if (! empty($difference1) || ! empty($difference2)) {
//         $validation = true;
//     }
//     return $validation;
// }
