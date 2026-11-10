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

## Picha (gallery albums) – `data/picha.js`

The gallery is a set of albums, one per event or group. To add an album:

1. Put the photos in a folder, e.g. `images/albamu/mavuno-2026/` (resize large phone photos to about 1600px wide first).
2. Add an entry at the top of `window.PICHA` in `data/picha.js`:

```js
{ jina: 'Sikukuu ya Mavuno 2026', tarehe: '2026-11-29', kundi: 'matukio',
  maelezo: 'Shukrani kwa Bwana kwa mavuno',
  picha: ['images/albamu/mavuno-2026/01.jpg', 'images/albamu/mavuno-2026/02.jpg'] }
```

`kundi` is one of `ibada`, `kwaya`, `watoto`, `matukio`, `uongozi`. The first photo is the cover. Albums are
sorted newest first. Entries written as `'ikoni:...'` are sample frames; replace them with real photo paths.

## Matangazo (announcements) – `data/matangazo.js`

All announcements and events live in one file, `data/matangazo.js`. The Matangazo page and the front-page
panels both read from it, so each notice is written once. Dates are written as `'YYYY-MM-DD'`.
English fields (`kichwa_en`, `maelezo_en`, `saa_en`) are optional.

**Kila Jumapili (every Sunday):**
1. Copy the current `wiki` block to the top of `zilizopita` (past notices).
2. Write the new `wiki`: the Sunday date (`tarehe`) and its notices (`orodha`).

**Muda mrefu (long-term notices)** such as Mavuno, building harambee or Kipaimara registration have a
`kuanzia` (start) and `hadi` (end) date. They show "Siku X zimebaki" with a progress bar and disappear by
themselves after the end date. **Matukio (events)** also hide themselves once their date has passed.

To see all long-term notices regardless of dates, add `?all=1` to the address of `matangazo.html`.

## Sermons on YouTube (`mahubiri.html`)

Each sermon has a `data-yt=""` attribute. To connect a video, paste the YouTube video ID between the quotes.
The ID is the part after `v=` in the link: for `https://www.youtube.com/watch?v=AbC123xYz`, the ID is `AbC123xYz`.

- **Main player:** `<div class="yt" data-yt="...">` near the top. Put the newest sermon here, and update the
  title, Bible reading, preacher and date next to it.
- **Sermon list:** each `<button class="srow" data-yt="...">`. Clicking a row plays that video in the main player.
- **Channel button:** set the `href` of `<a class="yt-channel" ...>` to the church's YouTube channel link.

Sermons without an ID show the cross artwork and "Video itawekwa hivi karibuni". Videos only load when someone
presses play, which saves mobile data.

## Live services (Mubashara)

Live mode is set at the top of `site.js` in `LIVE_CONFIG`:

```js
var LIVE_CONFIG = {
  channelId: '',                                          // the church's YouTube channel ID, starts with "UC"
  schedule: [ { day: 0, start: '06:45', end: '12:30' } ], // 0 = Sunday; Tanzania time
  force: false                                            // true = show live mode now (special services)
};
```

Once `channelId` is filled in, the site switches itself to live mode during the scheduled hours: a red
"Mubashara" badge appears in the menu on every page, a red "Ibada inaendelea mubashara" button appears on the
front page, and the player on the sermons page plays whatever is live on the channel. Nothing needs changing
each Sunday. To find the channel ID: on YouTube open the channel, then **About → Share channel → Copy channel ID**.

To preview live mode at any time, add `?live=1` to the address, e.g. `index.html?live=1`.

## Hosting

The site is plain HTML, CSS and JavaScript with no build step. It is published with GitHub Pages from the `main` branch.
