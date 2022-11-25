<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{asset("/css/style.css")}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.9/styles/atom-one-light.min.css">

    <title>MPIT редактор</title>
</head>

<body>
    <div class="headerr">
      <div class="header_section">
        <div class="header_item header_logo">#Дневник Хакатонщика</div>
      </div>
      <div class="header_section">
        <div class="header_item header_button">Редактор</div>
        <div class="header_item header_button">Архив</div>
      </div>

      <div class="header_section">
          @auth()
              <div class="header_item header_button">
                  <a href="{{ route('auth.delete') }}" style="text-decoration: none; color: black">
                      Выход
                  </a>
              </div>
          @endauth
          @guest()
              <div class="header_item header_button">
                  <a href="{{ route('auth.social') }}" style="text-decoration: none; color: black">
                      Вход
                  </a>
              </div>
          @endguest


      </div>
    </div>

    <div class="git">
          <div class="git_section">
            <h2>
                @auth()
                    <img src="{{auth()->user()->getAvatar()}}" alt="" height="50px" width="50px">
                    {{auth()->user()->nickname}}
                @endauth
                @guest()
                    Нет профиля
                @endguest
            </h2>
            <textarea class="commits"></textarea>
            <div>
              <div class="btn_section">
                <div class="btn_items"><button>Сохранить</button></div>
                <div class="btn_items"><button>Загрузить</button></div>
                <div class="btn_items"><button>Отправить</button></div>
              </div>
            </div>
          </div>
          <div class="git_section">
            <h2>Дерево Гита</h2>
            <div id="multi-derevo" class="git_tree">
              <h4><a href="#">Заголовок</a></h4>
              <ul>
               <li><span><a>1. Ветка</a></span>
                 <ul>
                  <li><span><a>1.1. Ветка</a></span>
                    <ul>
                     <li><span><a>1.1.1. Листик</a></span></li>
                     <li><span><a>1.1.2. Цветок </a></span></li>
                     <li><span><a>1.1.3. Цветок </a></span></li>
                    </ul>
                  </li>
                 </ul>
               </li>
               <li><span><a href="#2">2. Ветка</a></span></li>
              </ul>
            </div>
          </div>
        </div>

    <div class="page">
        <div class="menu">
            <div class="control-buttons">
                <div class="clear button">🔥</div>
                <div class="vert-line"></div>
                <div class="undo button">↺</div>
                <div class="redo button">↻</div>
                <div class="vert-line"></div>
                <div class="bold button">b</div>
                <div class="italic button">i</div>
                <div class="underline button">u</div>
                <div class="strikethrough button">s</div>
                <div class="vert-line"></div>
                <div class="header button">Hн</div>
                <div class="mark button">▢</div>
                <div class="code button">≺≻</div>
                <div class="quote button">❞❝</div>
            </div>
            <div id="view-button" class="view-button button">Preview</div>
        </div>
        <div class="fullsize-editor">
            <textarea id="markdown" class="edit_block block" spellcheck="false">
# Использование языка разметки Markdown

*Статья почти полностью взята из [документации Microsoft](https://docs.microsoft.com/ru-ru/contribute/how-to-write-use-markdown)*

Статьи на сайте [docs.microsoft.com](http://docs.microsoft.com/) написаны на [Markdown](https://daringfireball.net/projects/markdown/) — упрощенном языке разметки, который легко использовать и изучать. Благодаря своей простоте он быстро становится отраслевым стандартом. Для документов сайта используется [тип Markdig](https://docs.microsoft.com/ru-ru/contribute/how-to-write-use-markdown#markdown-flavor) разметки Markdown.

## Базовые сведения о Markdown

### Заголовки

Чтобы создать заголовок, используйте знак (#), например:

```markdown
# This is heading 1
## This is heading 2
### This is heading 3
#### This is heading 4
```

В заголовках следует использовать стиль atx, то есть 1–6 символов решетки (`#`) в начале строки, чтобы указать на заголовок, соответствующий заголовкам HTML уровней с H1 по H6. Сверху приводятся примеры заголовков с первого по четвертый уровень.

В статье **должен** быть только один заголовок первого уровня (H1), который будет отображаться как заголовок страницы.

Заголовки второго уровня создадут оглавление, которое будет отображаться в разделе "В этой статье" под заголовком статьи.


### Полужирное начертание и курсив

Чтобы задать для текста **полужирное начертание**, заключите его в двойные звездочки:

``markdown
This text is **bold**.
``

Чтобы задать для текста *курсивное начертание*, заключите его в одинарные звездочки:

``markdown
This text is *italic*.
``

Чтобы задать для текста ***полужирное и курсивное начертание***, заключите его в тройные звездочки:

``markdown
This is text is both ***bold and italic***.
``


### Блоки цитирования

Блоки цитирования создаются с помощью символа `>`:

``markdown
> The drought had lasted now for ten million years, and the reign of the terrible lizards had long since ended. Here on the Equator, in the continent which would one day be known as Africa, the battle for existence had reached a new climax of ferocity, and the victor was not yet in sight. In this barren and desiccated land, only the small or the swift or the fierce could flourish, or even hope to survive.``

Предыдущий пример отображается следующим образом:

> Засуха продолжалась десять миллионов лет, и царству ужасных ящеров уже давно пришел конец. Здесь, близ экватора, на материке, который позднее назовут Африкой, с новой яростью вспыхнула борьба за существование, и еще не ясно было, кто выйдет из нее победителем. На этой бесплодной, иссушенной зноем земле благоденствовать или хотя бы просто выжить могли только маленькие, или ловкие, или свирепые.


### Списки

#### Неупорядоченный список

Неупорядоченный (маркированный) список можно отформатировать с помощью звездочек или тире. Например, следующая разметка Markdown:
``markdown
- List item 1
- List item 2
- List item 3
``
будет отображаться как:

- List item 1
- List item 2
- List item 3

Чтобы вложить один список в другой, добавьте отступ для элементов дочернего списка. Например, следующая разметка Markdown:
markdown
``markdown
- List item 1
  - List item A
  - List item B
- List item 2
``
будет отображаться как:

- List item 1
  - List item A
  - List item B
- List item 2

#### Упорядоченный список

Упорядоченный (ступенчатый) список можно отформатировать с помощью соответствующих цифр. Например, следующая разметка Markdown:

``markdown
1. First instruction
1. Second instruction
1. Third instruction
``

будет отображаться как:

1. First instruction
1. Second instruction
1. Third instruction

Чтобы вложить один список в другой, добавьте отступ для элементов дочернего списка. Например, следующая разметка Markdown:

``markdown
1. First instruction
   1. Sub-instruction
   1. Sub-instruction
1. Second instruction
``
будет отображаться как:

1. First instruction
   1. Sub-instruction
   1. Sub-instruction
1. Second instruction

Обратите внимание, что мы используем "1." для всех записей. Так проще увидеть различия, когда потом будут добавлены новые шаги или удалены существующие.


### Создание ссылок

Синтаксис Markdown для встроенной ссылки состоит из части `[link text]`, представляющей текст гиперссылки, и части `(file-name.md)` — URL-адреса или имени файла, на который дается ссылка:
``markdown
[link text](file-name.md)
``
Также, ссылки для удобства можно писать в подобном формате:

``markdown
text text text [link][smalltext] text text

[smalltext]: link title
``
И это будет выглядить так:
text text text [link][smalltext] text text

[smalltext]: link title

Дополнительные сведения о ссылках:

- [Markdown: Syntax](https://daringfireball.net/projects/markdown/syntax#link) (Руководство по синтаксису Markdown), в котором предоставлена основная информация по поддержке ссылок Markdown.
- Страница [Ссылки](https://docs.microsoft.com/ru-ru/contribute/how-to-write-links) в этом руководстве содержит сведения о дополнительном синтаксисе Markdig для ссылок.


### Изображения

Синтаксис Markdown для изображений очень схож с состоит из части `![image title]`, представляющей заголовок отображаемый при наведении, и части `(file-name.jpg)` — URL-адреса или имени файла, содержащего изображение:
``markdown
![Yes](https://i.imgur.com/sZlktY7.png)
``
**Отображение**
![Yes](https://i.imgur.com/sZlktY7.png)

Ссылки и изображения можно комбинировать:
``markdown
[![Yes](https://i.imgur.com/sZlktY7.png)](https://i.imgur.com/sZlktY7.png)
``
**Отображение**
[![Yes](https://i.imgur.com/sZlktY7.png)](https://i.imgur.com/sZlktY7.png)


### Сноски
Подобным образом можно делать сноски в тексте на авторов или источники:
``markdown
text text text word[^1] text text

[^1]: footnote
``
**Отображение**
text text text word[^1] text text

[^1]: footnote
Пояснения создаются в конце страницы.


### Фрагменты кода

Markdown поддерживает как встраивание фрагментов кода в предложение, так и их размещение между предложениями в виде отдельных огражденных блоков. Дополнительная информация:

- Сведения о собственной поддержке блоков кода Markdown
- Сведения о поддержке GFM для ограждения кода и выделения синтаксиса

Огражденные блоки кода — это простой способ выделить синтаксис для фрагментов кода. Общий формат огражденных блоков кода:
```markdown
\`\`\`
...
your code goes in here
...
\`\`\`
```
Пример. C#

```markdown
\`\`\`
// Hello1.cs
public class Hello1
{
    public static void Main()
    {
        System.Console.WriteLine("Hello, World!");
    }
}
\`\`\`
```

**Отображение**

```csharp
// Hello1.cs
public class Hello1
{
    public static void Main()
    {
        System.Console.WriteLine("Hello, World!");
    }
}
```

Пример. SQL

```sql
\`\`\`
CREATE TABLE T1 (
  c1 int PRIMARY KEY,
  c2 varchar(50) SPARSE NULL
);
\`\`\`
```
**Отображение**

```
CREATE TABLE T1 (
  c1 int PRIMARY KEY,
  c2 varchar(50) SPARSE NULL
);

```


### Дополнительные материалы

#### Ресурсы Markdown

- [Markdown: Syntax](https://daringfireball.net/projects/markdown/syntax) (Синтаксис Markdown)
- [Markdown cheat-sheet](https://docs.microsoft.com/ru-ru/contribute/media/documents/markdown-cheatsheet.pdf?raw=true) (Шпаргалка по Markdown)
- [Базовые сведения о разметке Markdown на GitHub](https://help.github.com/articles/markdown-basics/)
- [The Markdown Guide](https://www.markdownguide.org/) (Руководство по Markdown)
        </textarea>
            <article id="preview" class="block">
            </article>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.9/highlight.min.js"></script>
    <script src="{{asset("/js/mdconverter.js")}}"></script>
    <script src="{{asset("/js/editor.js")}}"></script>
    <script src="{{asset("/js/jquery-3.6.1.min.js")}}"></script>
    <script src="{{asset("/js/jquery_cookie.js")}}" type="text/javascript"></script>
    <script src="{{asset("/js/codee.js")}}"></script>


</body>

</html>
