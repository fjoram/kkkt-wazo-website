<?php
/* What each content type looks like in the admin area.
   Field: [label, type, extra]. Types: text, textarea, date, number, select, icon, youtube, image.
   Fields ending in _en are optional English versions. */
$CATS = ['ibada' => 'Ibada', 'kwaya' => 'Kwaya', 'watoto' => 'Watoto', 'matukio' => 'Matukio', 'uongozi' => 'Uongozi'];
$ICONS = array_combine(icon_names(), icon_names());
return [
  'announcements' => [
    'title' => 'Matangazo ya wiki', 'one' => 'tangazo', 'order' => 'sunday_date DESC, sort, id',
    'help' => 'Kila tangazo lina tarehe ya Jumapili linalosomwa. Jumapili ya karibuni zaidi ndiyo "Matangazo ya wiki"; za zamani huenda kwenye "Matangazo yaliyopita" zenyewe.',
    'list' => ['sunday_date' => 'Jumapili', 'label' => 'Aina', 'title_sw' => 'Kichwa'],
    'group' => 'sunday_date',
    'fields' => [
      'sunday_date' => ['Tarehe ya Jumapili', 'date', ['required' => true, 'default' => fn() => date('Y-m-d', strtotime('sunday this week'))]],
      'label' => ['Aina (mf. Mavuno, Ubatizo, Ndoa, Harambee)', 'text'],
      'title_sw' => ['Kichwa', 'text', ['required' => true]], 'title_en' => ['Kichwa (Kiingereza)', 'text'],
      'body_sw' => ['Maelezo', 'textarea'], 'body_en' => ['Maelezo (Kiingereza)', 'textarea'],
      'sort' => ['Mpangilio (namba ndogo kwanza)', 'number'],
    ]],
  'notices' => [
    'title' => 'Kumbukumbu za muda mrefu', 'one' => 'kumbukumbu', 'order' => 'end_date DESC',
    'help' => 'Matangazo ya wiki kadhaa (Mavuno, ujenzi, usajili). Yanaonekana kuanzia tarehe ya mwanzo hadi ya mwisho, kisha hujiondoa yenyewe.',
    'list' => ['label' => 'Aina', 'title_sw' => 'Kichwa', 'start_date' => 'Kuanzia', 'end_date' => 'Hadi'],
    'fields' => [
      'label' => ['Aina (mf. Mavuno, Ujenzi)', 'text'],
      'title_sw' => ['Kichwa', 'text', ['required' => true]], 'title_en' => ['Kichwa (Kiingereza)', 'text'],
      'body_sw' => ['Maelezo', 'textarea'], 'body_en' => ['Maelezo (Kiingereza)', 'textarea'],
      'start_date' => ['Kuanzia tarehe', 'date', ['required' => true]], 'end_date' => ['Hadi tarehe', 'date', ['required' => true]],
    ]],
  'events' => [
    'title' => 'Matukio', 'one' => 'tukio', 'order' => 'event_date DESC',
    'help' => 'Matukio yajayo. Tukio hujiondoa lenyewe tarehe yake ikipita.',
    'list' => ['event_date' => 'Tarehe', 'title_sw' => 'Tukio', 'time_sw' => 'Saa'],
    'fields' => [
      'event_date' => ['Tarehe', 'date', ['required' => true]],
      'title_sw' => ['Tukio', 'text', ['required' => true]], 'title_en' => ['Tukio (Kiingereza)', 'text'],
      'time_sw' => ['Saa (mf. Saa 3:00 asubuhi)', 'text'], 'time_en' => ['Saa (Kiingereza, mf. 9:00 AM)', 'text'],
    ]],
  'sermons' => [
    'title' => 'Mahubiri', 'one' => 'mahubiri', 'order' => 'sermon_date DESC, id DESC',
    'help' => 'Bandika kiungo cha YouTube cha mahubiri. Mahubiri mapya zaidi huonekana kwanza.',
    'list' => ['sermon_date' => 'Tarehe', 'title_sw' => 'Kichwa', 'preacher' => 'Mhubiri', 'youtube' => 'YouTube'],
    'fields' => [
      'sermon_date' => ['Tarehe', 'date', ['required' => true, 'default' => fn() => date('Y-m-d', strtotime('last sunday', strtotime('tomorrow')))]],
      'title_sw' => ['Kichwa', 'text', ['required' => true]], 'title_en' => ['Kichwa (Kiingereza)', 'text'],
      'ref_sw' => ['Somo la Biblia (mf. Yohana 15:1–8)', 'text'], 'ref_en' => ['Somo (Kiingereza, mf. John 15:1–8)', 'text'],
      'preacher' => ['Mhubiri', 'text'],
      'youtube' => ['Kiungo cha YouTube', 'youtube'],
    ]],
  'albums' => [
    'title' => 'Albamu za picha', 'one' => 'albamu', 'order' => 'album_date DESC, id DESC',
    'help' => 'Unda albamu, kisha bonyeza "Picha" kupakia picha zake.',
    'list' => ['album_date' => 'Tarehe', 'title_sw' => 'Albamu', 'category' => 'Kundi'],
    'photos' => true,
    'fields' => [
      'title_sw' => ['Jina la albamu', 'text', ['required' => true]], 'title_en' => ['Jina (Kiingereza)', 'text'],
      'desc_sw' => ['Maelezo mafupi', 'text'], 'desc_en' => ['Maelezo (Kiingereza)', 'text'],
      'album_date' => ['Tarehe', 'date', ['required' => true]],
      'category' => ['Kundi', 'select', ['options' => $CATS]],
    ]],
  'leaders' => [
    'title' => 'Uongozi', 'one' => 'kiongozi', 'order' => "FIELD(tier,'pastor','staff'), sort, id",
    'help' => 'Wachungaji huonekana kwa picha kubwa. Mchungaji wa kwanza kwenye orodha huonekana kwenye ukurasa wa mwanzo.',
    'list' => ['photo' => '', 'name' => 'Jina', 'role_sw' => 'Cheo', 'tier' => 'Kundi'],
    'fields' => [
      'name' => ['Jina (mf. Mch. Herman Kiporoza)', 'text', ['required' => true]],
      'role_sw' => ['Cheo', 'text', ['required' => true]], 'role_en' => ['Cheo (Kiingereza)', 'text'],
      'tier' => ['Kundi', 'select', ['options' => ['pastor' => 'Mchungaji', 'staff' => 'Watumishi / Baraza']]],
      'photo' => ['Picha (wima, kichwa juu)', 'image', ['dir' => 'leaders', 'max' => 900]],
      'sort' => ['Mpangilio (namba ndogo kwanza)', 'number'],
    ]],
  'services' => [
    'title' => 'Ibada za Jumapili', 'one' => 'ibada', 'order' => 'sort, id',
    'list' => ['time_sw' => 'Saa', 'name_sw' => 'Ibada'],
    'fields' => [
      'time_sw' => ['Saa (saa za Kiswahili, mf. 1:00)', 'text', ['required' => true]], 'period_sw' => ['Kipindi (mf. asubuhi)', 'text'],
      'time_en' => ['Saa (Kiingereza, mf. 7:00)', 'text', ['required' => true]], 'period_en' => ['Kipindi (Kiingereza, mf. AM)', 'text'],
      'name_sw' => ['Jina la ibada', 'text', ['required' => true]], 'name_en' => ['Jina (Kiingereza)', 'text'],
      'short_sw' => ['Maelezo mafupi (ukurasa wa mwanzo)', 'text'], 'short_en' => ['Maelezo mafupi (Kiingereza)', 'text'],
      'desc_sw' => ['Maelezo (ukurasa wa Ibada)', 'textarea'], 'desc_en' => ['Maelezo (Kiingereza)', 'textarea'],
      'sort' => ['Mpangilio', 'number'],
    ]],
  'schedule' => [
    'title' => 'Ratiba ya wiki', 'one' => 'shughuli', 'order' => 'sort, id',
    'list' => ['day_sw' => 'Siku', 'time_sw' => 'Saa', 'activity_sw' => 'Shughuli'],
    'fields' => [
      'day_sw' => ['Siku', 'text', ['required' => true]], 'day_en' => ['Siku (Kiingereza)', 'text'],
      'time_sw' => ['Saa', 'text', ['required' => true]], 'time_en' => ['Saa (Kiingereza)', 'text'],
      'activity_sw' => ['Shughuli', 'text', ['required' => true]], 'activity_en' => ['Shughuli (Kiingereza)', 'text'],
      'icon' => ['Alama', 'icon', ['options' => $ICONS]], 'sort' => ['Mpangilio', 'number'],
    ]],
  'fellowships' => [
    'title' => 'Vikundi', 'one' => 'kikundi', 'order' => 'sort, id',
    'list' => ['name_sw' => 'Kikundi', 'meet_sw' => 'Hukutana'],
    'fields' => [
      'name_sw' => ['Jina la kikundi', 'text', ['required' => true]], 'name_en' => ['Jina (Kiingereza)', 'text'],
      'desc_sw' => ['Maelezo', 'textarea'], 'desc_en' => ['Maelezo (Kiingereza)', 'textarea'],
      'meet_sw' => ['Hukutana lini', 'text'], 'meet_en' => ['Hukutana (Kiingereza)', 'text'],
      'icon' => ['Alama', 'icon', ['options' => $ICONS]], 'sort' => ['Mpangilio', 'number'],
    ]],
];
