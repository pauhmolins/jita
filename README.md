# JITA Website

I am not versed in WordPress.
When tasked with updating the JITA website for the upcoming conference edition,
I went for the simplest solution (to me): a static HTML site served through WordPress.
Much easier to create and iterate on, especially with LLMs.

## How it works

The Blankslate theme is stripped down to two PHP templates:

- **`front-page.php`** — serves `static/index.html` as the site homepage
- **`page.php`** — serves `static/{slug}/index.html` based on the WordPress page slug

So a WordPress page with slug `jita2026` will serve `static/jita2026/index.html`.

## Structure

```
blankslate/
  front-page.php        # serves static/index.html
  page.php              # serves static/{slug}/index.html
  ...
  static/
    index.html          # homepage (lists all editions)
    jita2025/           # 2025 edition
    jita2026/           # 2026 edition
    ...
```

## Setup

Assumes WordPress is already installed and running.

1. Install and activate the [Blankslate](https://wordpress.org/themes/blankslate/) theme from the WordPress admin.
2. Install a file manager plugin (e.g. [WP File Manager](https://wordpress.org/plugins/wp-file-manager/)) to upload and edit files without SSH.
3. Replace `front-page.php` and `page.php` in `wp-content/themes/blankslate/` with the ones from this repo, and upload the `static/` folder alongside them.
4. In the WordPress admin, set the front page to a static page, then create pages whose slugs match the subfolder names under `static/` (e.g. `jita2025`, `jita2026`).
5. Static assets (images, files) go inside the corresponding subfolder and are referenced relative to it.
6. Disable the file manager plugin after uploading files for security.

### Local browsing

Two things need to be adjusted to browse the site locally:

**Edition pages** (`jita2026/index.html`, etc.) — swap the `<base href>` from the WordPress path to `./`:

```html
<!-- <base href="/wp-content/themes/blankslate/static/jita2026/"> -->
<base href="./">
```

**Homepage** (`index.html`) — swap the edition card links from WordPress page slugs to relative file paths:

```html
<!-- <a href="jita2025" class="edition-card y2025"> -->
<a href="jita2025/index.html" class="edition-card y2025">

<!-- <a href="jita2026" class="edition-card y2026"> -->
<a href="jita2026/index.html" class="edition-card y2026">
```

Remember to revert both before deploying.

## Adding a new edition

1. Duplicate an existing edition folder (e.g. copy `jita2026/` → `jita2027/`).
2. Update content, images, and the `<base href>` path inside the new `index.html`.
3. Create a matching WordPress page with the corresponding slug.
4. Add a new edition card to `static/index.html` (the main homepage listing all editions).
5. Upload both the new edition folder and the updated `index.html` to `wp-content/themes/blankslate/static/` on the server.