# Kiryi's PAGYI
A page builder using a JSON configuration file and Markdown texts.

## Installation
```bash
composer require kiryi/pagyi
```

## Usage
- Copy the [CSS rules](#css-rules) to your stylesheet
- Create your page's [configuration](#json-configuration)
- [Initialize](#initialization) the builder in one of three possible ways
- Run the [build function](#method-definition-build)

## Constructor Definition

```php
__construct(
    ?string $initConfigFilepath,
    ?string $imgDir = null,
    ?string $imgPath = null,
    ?string $baseUrl = null
)
```
### Parameters
**initConfigFilepath**  
You can initialize your builder by passing a filepath to an INI file. If you don't want to use a file you can pass `null` and pass the other parameters instead ([more information](#initialization)). 

**imgDir**  
The image directory relative to your project's root directory. Optional if you use an initialization file ([more information](#initialization)).  

**imgPath**  
The image path relative to your base URL. Optional if you use an initialization file ([more information](#initialization)).  

**baseUrl**  
The base URL of your web application. Optional if you use an initialization file ([more information](#initialization)).

## Method Definition *build*
```php
build(string $buildConfigFilepath, string $textDir): string
```
### Parameters
**buildConfigFilepath**  
The JSON configuration filepath relative to your project's root directory.

**textDir**  
The Markdown texts directory path relative to your project's root directory.

### Return Values
Returns the fully rendered HTML of your configured page.

## Initialization
You have to provide the builder at least three mandatory parameters.

**baseUrl**  
The base URL of your web application.

**imagePath**  
The image path relative to your base URL.

**imageDirectory**  
The image directory relative to your project's root directory.

The parameters can be provided by using a custom configuration file with the following contents:
```ini
[pagyi]
baseUrl = {YOURBASEURL}
imagePath = {YOURIMAGEPATH}
imageDirectory = {YOURIMAGEDIRECTORY}
```
The filepath to the above INI file has then to be passed to the [constructor](#constructor-definition). If you already using Kiryi's VIEWYI view engine you probably set up two of the parameters in another INI file. In this case it is possible to add the third one `imageDirectory` to your [VIEWYI configuration file](https://github.com/KiryiMONZTA/viewyi#initialization) directly to the `[viewyi]` section and pass this already existing file to the [constructor](#constructor-definition).

If you have set up the configuration file, you have to provide the path to the constructor:
```php
$pagyi = new \Kiryi\Pagyi\Builder({YOURFILEPATH});
```

If you don't want to use an INI file at all, just pass the needed parameters to the constructor and set the filepath `initConfigFilepath` to `null`.
```php
$pagyi = new \Kiryi\Pagyi\Builder(
    null,
    '{YOURBASEURL}',
    '{YOURIMAGEPATH}',
    '{YOURIMAGEDIRECTORY}',
);
```
You can also overwrite a single parameter by passing it to the constructor even if you set up a configuration file.

## CSS Rules
For a correct presentation of the page, copy the CSS rules from `{pagyi}/asset/css/pagyi.css` to your project's CSS file or include PAGYI's file into your web page.

## JSON Configuration
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
        "image": {
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
- `image` is the name including the file exentions of the [image](#images), which will be shown beside the text
- `link` adds a button at the end of the text
- All properties are optional

### Layout Types
Property `type` tells PAGYI which layout to use. Default value is *normal*.

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

#### Parameter **no-padding**
The additional parameter `no-padding` could be added to the types `left` and `right`. Normally the sections have some space between:
```
|text.......||           |
|...........||image      |
|button|    ||           |

|           ||text.......|
|      image||...........|
|           ||button|    |
```
Parameter `no-padding` removes this space.
```
|text.......||           |
|...........||image      |
|button|    ||           |
|           ||text.......|
|      image||...........|
|           ||button|    |
```
Combined with good images, it's possible to create a chessboard-looking design.

### Images
- `normal` and `center` layout could display images up to a width of 1200px
- `left` and `right` layout display a maximum width of 600px
- Best result with `left` and `right` is achieved with the maximum image width and a height, that is no less than the text's height
- You may also add small icon-like images - it looks perfect with the type `center`

## Example
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
        "image": {
            "file": "example01.png"
        }
    }
    {
        "id": "exampleSection02",
        "type": "right no-padding",
        "text": "exampleTextFile02",
        "image": {
            "file": "example02.png"
        }
    }
]
```
Then initialize the Page Builder
```php
$pagyi = new \Kiryi\Pagyi\Builder(
    null,
    'public/img',
    'img',
    'http://pagyi-test.com',
);
```
and build the page
```php
$page = $pagyi->build(
    'asset/json/builderConfiguration.json',
    'asset/text',
);
```
You can now simply echo it
```php
echo $page;
```
- This will print a page with two sections
- Both containing a text and an image
- The first has the image on the right side
- The second switches the order and shows the image on the left

Even better is using Kiryi's VIEWYI to build a whole HTML5 web page
```php
$viewyi->assign('body', $page);
$viewyi->render('home');
$viewyi->display('head', 'PAGYI Test');
```
For more information about the VIEWYI set up and usage, please read [VIEWY's README](https://github.com/KiryiMONZTA/viewyi#kiryis-viewyi). Since PAGYI is using VIEWYI internally, it is a good choice to combine both.
