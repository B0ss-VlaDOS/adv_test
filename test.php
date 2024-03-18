<?php
use PHPUnit\Framework\TestCase;

class WordReverser {
    public function reverseWords($str) {
        // Разбиваем строку на слова с учетом пунктуации
        $words = preg_split('/(\W+)/u', $str, -1, PREG_SPLIT_DELIM_CAPTURE);

        $result = array_map(function($word) {
            if (!preg_match('/\w+/u', $word)) {
                // Если элемент не содержит букв или цифр (только пунктуация), возвращаем его без изменений
                return $word;
            }
            
            // Разбиваем слово на массив символов
            $letters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);

            // Массив индексов заглавных букв
            $uppercaseIndexes = [];

            foreach ($letters as $index => $letter) {
                if (mb_strtoupper($letter, 'UTF-8') === $letter) {
                    $uppercaseIndexes[] = $index;
                }
            }

            // Переворачиваем массив букв
            $reversedLetters = array_reverse($letters);

            // Применяем регистр
            foreach ($uppercaseIndexes as $index) {
                if (isset($reversedLetters[$index])) {
                    $reversedLetters[$index] = mb_strtoupper($reversedLetters[$index], 'UTF-8');
                }
            }
            
            // Собираем слово
            return implode('', $reversedLetters);
        }, $words);

        // Собираем строку
        return implode('', $result);
    }
}

// Создаем экземпляр класса
$reverser = new WordReverser();

class ReverseWordsTest extends TestCase {
    public function testReverseWordsWithPunctuation() {
        $reverser = new WordReverser();

        // Теперь вызываем метод reverseWords через созданный объект $reverser
        $this->assertEquals('Tac', $reverser->reverseWords('Cat'));
        $this->assertEquals('esuOh', $reverser->reverseWords('houSe'));
        $this->assertEquals('Амиз:', $reverser->reverseWords('Зима:'));
        $this->assertEquals("si 'dloc' won", $reverser->reverseWords("is 'cold' now"));
        $this->assertEquals('отэ «Так» "отсорп"', $reverser->reverseWords('это «Так» "просто"'));
        $this->assertEquals('driht-trap', $reverser->reverseWords('third-part'));
    }
}


// Тестовая строка
//$var = "Эйфлятляюкудль";

// Вызываем метод класса
//echo $reverser->reverseWords($var);

?>
