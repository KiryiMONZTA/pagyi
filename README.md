# Kiryi's PAGYI
A page builder using a JSON configuration file and Markdown texts.

## Installation
```bash
composer require kiryi/pagyi
```

## Usage
First initialize the engine in one of three possible ways. See [Initialization](#initialization) for more information. Then use the provided functions as described below. Also build your templates as described in the section [Templating](#templating).

## Constructor Definition

```php
__construct($config)
```
### Parameters
**config**  
Optional configuration array or filepath to custom configuration INI file. If nothing is provided, default (*config/viewyi.ini*) is used ([more information](#initialization)). 

## Method Definition *assign*
```php
assign(string $key, $value): void
```
Assigns a variable to the view's data object.
### Parameters
**key**  
The variable's key.

**key**  
The variable's value. Can be string, any number, array, bool or null.

## Method Definition *reset*
```php
reset(): void
```
Resets the view's data object. Usually this it not actually necessary, but can help sometimes if you are dealing with several render sections on one page.

## Method Definition *render*
```php
render(string $template): string
```
Renders the current view (HTML page). Have to be called before `display`.
### Parameters
**template**  
The template name to use as render base.

### Return Values
Returns the fully rendered view.

## Method Definition *display*
```php
display(string $headTemplate, string $title): void
```
Finally displays the whole HTML page. It is necessary to call `render` at least once before. The rendered view is always embeded to the page's HTML body element. `display` can only be called once.
### Parameters
**headTemplate**  
The template name to embed into the HTML page's head element.

**title**  
The title of the current page set to the HTML page's title element.

## Initialization
You have to provide the engine at least three mandatory parameters as well as an optional fourth.

**baseUrl**  
The base URL of your web application.

**imagePath**  
The image directory path relative to your base URL.

**templateDirectory**  
The template directory path relative to your project's root directory.

**templateFileExtension (optional)**  
Optional file extension of your template files, if you want to use something else than the default `.php`.

The parameters can be provided by using the standard configuration file `{PROJECTSROOTDIRECTORY}/config/viewyi.ini` with the following contents:
```ini
[viewyi]
baseUrl = {YOURBASEURL}
imagePath = {YOURIMAGEDIRECTORYPATH}
templateDirectory = {YOURTEMPLATEDIRECTORYPATH}
templateFileExtension = {YOURFILEEXTENSION}
```
Or by passing another INI file path to the engines's constructor with the same contents. The path has to be relative to your project's root directory:
```php
$viewyi = new \Kiryi\Viewyi\Engine('{YOURCUSTOMFILEPATH}');
```
Or by passing an array with the three to four parameters to the constructor:
```php
$viewyi = new \Kiryi\Viewyi\Engine([
    'baseUrl' => '{YOURBASEURL}',
    'imagePath' => '{YOURIMAGEDIRECTORYPATH}',
    'templateDirectory' => '{YOURTEMPLATEDIRECTORYPATH}',
    'templateFileExtension' => '{YOURFILEEXTENSION}',
]);
```

## Templating
- Use native PHP templates.
- Therefore you may use any PHP alternative syntax control structure.
- Print any data you have assigned by writing `<?=$d->{YOURVARIABLEKEY}?>`.
- Build links with your base URL by writing `<a href='<?=$a>{YOURLINKRELATIVETOBASEURL}'>{LINKTEXT}<a>`.
- Include images by writing `<img src='<?=$i?>{YOURIMAGEINYOURIMAGEDIRECTORY}' />`.

## Example
*configuration/config.ini*
```ini
[viewyi]
baseUrl = https://viewyi-example.com
imagePath = img
templateDirectory = src/View
templateFileExtension = .tpl.php
```
*src/View/head.tpl.php*
```html
<link rel='stylesheet' href='<?=$a?>css/style.min.css' />
<link rel='shortcut icon' href='<?=$i?>favicon.png' />

```
*src/View/home.tpl.php*
```html
<img src='<?=$i?>logo.png' />
<h1><?=$d->headline?></h1>
<?php foreach($d->paragraphs as $paragraph): ?>
<p><?=$paragraph?></p>
<?php endforeach; ?>

```
*src/Controller/HomeController.php*
```php
$viewyi = new \Kiryi\Viewyi\Engine('configuration/config.ini');
$viewyi->assign('headline', 'Welcome To My Page');
$viewyi->assign('paragraphs', [
    'I want to show you the VIEWYI View Engine.',
    'It is very easy to use.',
    'Just follow this example.',
]);
$viewyi->render('home');
$viewyi->display('head', 'Welcome');
```
will generate the HTML5 page:
```html
<!DOCTYPE html>
<html>
<head>
<link rel='stylesheet' href='https://viewyi-example.com/css/style.min.css' />
<link rel='shortcut icon' href='https://viewyi-example.com/img/favicon.png' />
<title>Welcome</title>
</head>
<body>
<img src='https://viewyi-example.com/img/logo.png' />
<h1>Welcome To My Page</h1>
<p>I want to show you the VIEWYI View Engine.</p>
<p>It is very easy to use.</p>
<p>Just follow this example.</p>
</body>
</html>
```






-OLD----------------------------------------

## Usage
- Set up the [View Engine](https://github.com/KiryiMONZTA/view-engine#configuration-parameters)
- Copy the [CSS rules](#css-rules) to your project
- Create a [JSON configuration](#json-configuration)
- [Initialize](#initialization) the Page Builder
- [Build](#building) the page

### Initialization
```php
$buildController = new \Kiryi\PageBuilder\Controller\BuildController(string $configFile [, string $textDir = null, string $imgDir = null]);
```

#### Parameters
**configFile**  
JSON configuration filepath relative to your project's root directory.

**textDir**  
Optional Markdown texts directory path relative to your project's root directory, which overwrites the [global configuration](#global-directory-configuration).

**imgDir**  
Optional image directory path relative to your project's root directory, which overwrites the [global configuration](#global-directory-configuration).

### Building
```php
build(): string
```
#### Return Values
Returns the fully rendered page.

### CSS Rules
For a correct presentation of the page, copy the CSS rules from `{pageBuilder}/asset/css/pageBuilderStyle.css` to your project's CSS file or include the Page Builder's file into your web page.

### Global Directory Configuration
If you don't want to specify the text directory and/or your image directory at every initialization, you can set them globally in your project's `config.ini` file.
```ini
[page-builder]
textDir = {yourTextDirectory}
imgDir = {yourImageDirectory}
```
- Both parameters are relative to your project's root directory

### JSON Configuration
The page is build up from sections defined in a JSON configuration file.
```json
[
    {
        "id": "exampleSection",
        "type": "center",
        "color": {
            "font": "#3f0000",
            "background": "#eee"
        },
        "text": "exampleTextFile",
        "img": {
            "file": "example.png",
            "altText": "Just an example picture"
        },
        "link": {
            "text": "Example Button",
            "url": "https://kiryi.net/"
        }
    }
]
```
- Every object represents one `<section>` element in the rendered HTML page
- The number of sections isn't limited
- `id` is set as the element's *id*
- `type` defines the [layout](#layout-types)
- `color` consists of font color and background color
- `text` is the name of the Markdown text file, which will be printed
- `img` is the name including the file exentions of the [image](#images), which will be shown beside the text
- `link` adds a button at the end of the text
- All properties are optional.

### Layout Types
- `type` tells the Page Builder which layout to use
- default value is *normal*

#### normal
```
|text....................|
|button|                 |
|         image          |
```

#### left
```
|text.......||           |
|...........||image      |
|button|    ||           |
```

#### right
```
|           ||text.......|
|      image||...........|
|           ||button|    |
```

#### center
```
|         image          |
|..........text..........|
|        |button|        |
```

#### Parameter no-padding
- The parameter `no-padding` could be added to the type `left` and `right`.
- Normally the sections have some space between:
```
|text.......||           |
|...........||image      |
|button|    ||           |

|           ||text.......|
|      image||...........|
|           ||button|    |
```
- `no-padding` removes this space:
```
|text.......||           |
|...........||image      |
|button|    ||           |
|           ||text.......|
|      image||...........|
|           ||button|    |
```
- Combined with good images, it's possible to create a chessboard-looking design.

### Images
- `normal` and `center` layout could display images up to a width of 1400px.
- `left` and `right` layout display a maximum width of 700px.
- Best result with `left` and `right` is achieved with the maximum image width and a height, that is no less than the text height.
- You may also add small icon-like images. It looks perfect with the type `center`.

### Examples
Let's assume the following directory structure
```
asset
  json
    builderConfiguration.json
  text
    exampleTextFile01.md
    exampleTextFile02.md
public
  img
    example01.png
    example02.png
   index.php
```
Your `builderConfiguration.json` file looks like
```json
[
    {
        "id": "exampleSection01",
        "type": "left no-padding",
        "text": "exampleTextFile01",
        "img": {
            "file": "example01.png"
        }
    }
    {
        "id": "exampleSection02",
        "type": "right no-padding",
        "text": "exampleTextFile02",
        "img": {
            "file": "example02.png"
        }
    }
]
```
Then in your `index.php` initialize the Page Builder
```php
$buildController = new \Kiryi\PageBuilder\Controller\BuildController('asset/json/builderConfiguration.json', 'asset/text', 'public/img');
```
build the page
```php
$page = $buildController->build();
```
and print it
```php
echo $page;
```
- This will print a page with two sections
- Both containing a text and an image
- The first has the image on the right side
- The second switches the order and shows the image on the left