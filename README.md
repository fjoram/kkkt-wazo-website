# KKKT Usharika wa Wazo – Tovuti

Tovuti rasmi ya **KKKT Usharika wa Wazo** (Kanisa la Kiinjili la Kilutheri Tanzania, Dayosisi ya Mashariki na Pwani), Wazo, Dar es Salaam.

Website for the KKKT Wazo parish of the Evangelical Lutheran Church in Tanzania. The site is bilingual: Kiswahili (default) and English, switched with the button in the top menu.

## Pages

| File | Page |
| --- | --- |
| `index.html` | Mwanzo – home |
| `kuhusu.html` | Kuhusu – about the parish and its leadership |
| `ibada.html` | Ibada – Sunday services and weekly schedule |
| `vikundi.html` | Vikundi – ministries and fellowships |
| `picha.html` | Picha – gallery |
| `matangazo.html` | Matangazo – announcements and events |
| `mahubiri.html` | Mahubiri – sermons |
| `matoleo.html` | Matoleo – offerings and giving |
| `mawasiliano.html` | Mawasiliano – contact and map |

Shared files: `style.css` (all design), `site.js` (language switch, menu, illustrations, map), `images/` (photos).

## Editing text

Every piece of text appears twice, once per language:

```html
<span lang="sw">Ibada ya Kwanza</span><span lang="en">First service</span>
```

Change both when you update something. Text marked with `class="ph"` (shown with a gold highlight) is a placeholder that still needs the real details.

## Still to fill in

- Phone, email and P.O. box (`mawasiliano.html`)
- Lipa Namba and bank account (`matoleo.html`)
- Founding year, place and number of members (`kuhusu.html`)
- Names for Mhazini and Mwenyekiti wa Baraza la Wazee, and photos for the leaders
- Real service times, announcements and sermons
- Real photos to replace the sample illustrations in the gallery

## Sermons on YouTube (`mahubiri.html`)

Each sermon has a `data-yt=""` attribute. To connect a video, paste the YouTube video ID between the quotes.
The ID is the part after `v=` in the link: for `https://www.youtube.com/watch?v=AbC123xYz`, the ID is `AbC123xYz`.

- **Main player:** `<div class="yt" data-yt="...">` near the top. Put the newest sermon here, and update the
  title, Bible reading, preacher and date next to it.
- **Sermon list:** each `<button class="srow" data-yt="...">`. Clicking a row plays that video in the main player.
- **Channel button:** set the `href` of `<a class="yt-channel" ...>` to the church's YouTube channel link.

Sermons without an ID show the cross artwork and "Video itawekwa hivi karibuni". Videos only load when someone
presses play, which saves mobile data.

## Hosting

The site is plain HTML, CSS and JavaScript with no build step. It is published with GitHub Pages from the `main` branch.
