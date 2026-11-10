-- KKKT Usharika wa Wazo – starting content (current site content and samples)
SET NAMES utf8mb4;

INSERT INTO settings (k,v) VALUES
('phone','+255 757 950 416'),
('email','wazohillchurch21@gmail.com'),
('address','Wazo, Kinondoni, Dar es Salaam'),
('pobox',''),
('office_hours_sw','Jumanne hadi Ijumaa, saa 3:00 asubuhi hadi saa 10:00 jioni'),
('office_hours_en','Tuesday to Friday, 9:00 AM to 4:00 PM'),
('lipa_namba',''),
('bank_name',''),
('bank_account',''),
('diocese_sw','Mashariki na Pwani'),
('diocese_en','Eastern and Coastal'),
('district_sw','Mashariki na Pwani'),
('district_en','Eastern and Coastal'),
('preaching_points','50'),
('verse_sw','“Nalifurahi waliponiambia, Na twende nyumbani kwa BWANA.”'),
('verse_en','“I was glad when they said unto me, Let us go into the house of the LORD.”'),
('verse_ref_sw','Zaburi 122:1'),
('verse_ref_en','Psalm 122:1'),
('season_sw','Majilio yanakaribia|Jumapili 29 Novemba · Ibada moja saa 2:00 asubuhi'),
('season_en','Advent is coming|Sunday 29 November · One service at 8:00 AM'),
('pastor_message_sw','“Karibu nyumbani kwa Bwana. Iwe ni mara yako ya kwanza au umekuwa nasi kwa miaka mingi, kuna nafasi kwako katika familia hii ya imani. Njoo tumwabudu Mungu pamoja.”'),
('pastor_message_en','“Welcome to the house of the Lord. Whether it is your first time or you have been with us for many years, there is a place for you in this family of faith. Come and worship God with us.”'),
('youtube_channel_url',''),
('live_channel_id',''),
('live_day','0'),
('live_start','06:45'),
('live_end','12:30'),
('live_force','0'),
('history_start_year',''),
('history_start_place',''),
('history_parish_year',''),
('history_members','')
ON DUPLICATE KEY UPDATE v=VALUES(v);

INSERT INTO services (time_sw,period_sw,time_en,period_en,name_sw,name_en,short_sw,short_en,desc_sw,desc_en,sort) VALUES
('1:00','asubuhi','7:00','AM','Ibada ya Kwanza','First service','Kiswahili · Meza ya Bwana Jumapili ya kwanza ya mwezi','In Swahili · Holy Communion on the first Sunday of the month','Kiswahili. Meza ya Bwana hutolewa Jumapili ya kwanza ya kila mwezi.','In Swahili. Holy Communion on the first Sunday of every month.',0),
('3:00','asubuhi','9:00','AM','Shule ya Jumapili','Sunday School','Watoto wa miaka 3 hadi 13','Children aged 3 to 13','Watoto wa miaka 3 hadi 13 hujifunza Neno la Mungu kwa nyimbo na hadithi.','Children aged 3 to 13 learn God''s Word through songs and stories.',1),
('4:00','asubuhi','10:00','AM','Ibada ya Pili','Second service','Kiswahili · Kwaya Kuu na Kwaya ya Vijana','In Swahili · with the Main Choir and Youth Choir','Kiswahili, pamoja na Kwaya Kuu na Kwaya ya Vijana.','In Swahili, with the Main Choir and the Youth Choir.',2);

INSERT INTO schedule (day_sw,day_en,time_sw,time_en,activity_sw,activity_en,icon,sort) VALUES
('Jumanne','Tuesday','12:00 jioni','6:00 PM','Mazoezi ya Kwaya Kuu','Main Choir practice','music',0),
('Jumatano','Wednesday','12:00 jioni','6:00 PM','Ibada ya maombi na mafundisho ya Biblia','Prayer service and Bible study','cross',1),
('Jumamosi','Saturday','3:00 asubuhi','9:00 AM','Darasa la Kipaimara','Confirmation class','dove',2),
('Jumamosi','Saturday','12:30 jioni','6:30 PM','Jumuiya za nyumbani','Home cell fellowships','hands',3);

INSERT INTO announcements (sunday_date,label,title_sw,title_en,body_sw,body_en,sort) VALUES
('2026-11-15','Mavuno','Maandalizi ya Sikukuu ya Mavuno','Preparing for the Harvest Festival','Kila jumuiya ilete orodha ya wanajumuiya watakaoshiriki maandamano ya Mavuno kwa Katibu wa Baraza kabla ya Jumapili ijayo.','Each home cell should give the Council Secretary a list of members joining the Harvest procession before next Sunday.',0),
('2026-11-15','Ujenzi','Ujenzi wa nyumba ya mtumishi','Building the pastor''s house','Kazi ya kuweka paa imeanza. Shukrani kwa wote waliochangia. Michango inaendelea kupokelewa ofisini na kwa Lipa Namba ya usharika.','Roofing work has begun. Thank you to all who have contributed. Contributions are still received at the office and via the parish pay number.',1),
('2026-11-15','Ubatizo','Ubatizo wa watoto – Jumapili 22 Novemba','Infant baptism – Sunday 22 November','Wazazi na wasimamizi wa watoto watakaobatizwa wahudhurie mafundisho Jumamosi saa 3:00 asubuhi kanisani.','Parents and godparents of children to be baptised should attend instruction on Saturday at 9:00 AM in church.',2),
('2026-11-15','Ndoa','Matangazo ya ndoa – mara ya pili','Marriage banns – second reading','Ndugu [Jina la bwana harusi] na Ndugu [Jina la bibi harusi] wanakusudia kufunga ndoa takatifu tarehe 5 Desemba 2026. Mwenye sababu ya kuzuia ndoa hii aonane na Mchungaji.','Brother [Groom''s name] and Sister [Bride''s name] intend to be married on 5 December 2026. Anyone who knows a reason why they may not marry should see the Pastor.',3),
('2026-11-15','Shukrani','Ibada ya shukrani ya Umoja wa Wanawake','Women''s Fellowship thanksgiving','Umoja wa Wanawake utakuwa na ibada ya shukrani Jumapili ijayo katika ibada ya pili. Wote mnakaribishwa.','The Women''s Fellowship will hold a thanksgiving at next Sunday''s second service. All are welcome.',4),
('2026-11-08','','Matangazo ya ndoa – mara ya kwanza','','Ndugu [Jina] na Ndugu [Jina] wanakusudia kufunga ndoa takatifu tarehe 5 Desemba 2026.','',0),
('2026-11-08','','Harambee ya nyumba ya mtumishi','','Jumla ya michango ya harambee itatangazwa Jumapili ijayo. Mungu awabariki wote waliotoa.','',1),
('2026-11-08','','Mazoezi ya Kwaya Kuu','','Mazoezi yanaendelea Jumanne saa 12:00 jioni kujiandaa kwa Mavuno.','',2),
('2026-11-01','','Uzinduzi wa maandalizi ya Mavuno','','Maandalizi ya Sikukuu ya Mavuno 2026 yamezinduliwa rasmi leo.','',0),
('2026-11-01','','Usajili wa Ubarikio','','Usajili wa darasa jipya la Ubarikio utaanza Jumapili ijayo.','',1);

INSERT INTO notices (label,title_sw,title_en,body_sw,body_en,start_date,end_date) VALUES
('Mavuno','Sikukuu ya Mavuno 2026','Harvest Festival 2026','Sikukuu ya Mavuno itafanyika Jumapili 29 Novemba. Kila mwanausharika anakaribishwa kumshukuru Bwana kwa matoleo ya mavuno: fedha, mazao au mifugo.','The Harvest Festival will be held on Sunday 29 November. Every member is invited to thank the Lord with a harvest offering: money, produce or livestock.','2026-11-01','2026-11-29'),
('Ujenzi','Ujenzi wa nyumba ya mtumishi','Building the pastor''s house','Usharika unajenga nyumba ya Mchungaji. Lengo ni kumaliza ifikapo Juni 2027. Kila familia inaombwa kuchangia kadri ya uwezo wake.','The parish is building a house for the Pastor, aiming to finish by June 2027. Every family is asked to contribute as they are able.','2026-09-01','2027-06-30'),
('Ubarikio','Usajili wa Ubarikio (Kipaimara) 2027','Confirmation registration 2027','Wazazi wa vijana wenye umri wa miaka 13 na zaidi wawasajili ofisini kwa darasa jipya la Ubarikio linaloanza Januari 2027.','Parents of young people aged 13 and above should register them at the office for the new confirmation class starting January 2027.','2026-11-08','2026-12-20'),
('Ndoa','Semina ya wanandoa','Marriage seminar','Semina ya wanandoa na wanaotarajia kufunga ndoa itafanyika Jumapili 6 Desemba baada ya ibada ya pili. Jiandikishe ofisini.','A seminar for married and engaged couples will be held on Sunday 6 December after the second service. Register at the office.','2026-11-15','2026-12-06');

INSERT INTO events (event_date,time_sw,time_en,title_sw,title_en) VALUES
('2026-11-22','Saa 4:00 asubuhi','10:00 AM','Ubatizo wa watoto','Infant baptism'),
('2026-11-29','Saa 2:00 asubuhi','8:00 AM','Sikukuu ya Mavuno · Jumapili ya Kwanza ya Majilio','Harvest Festival · First Sunday of Advent'),
('2026-12-05','Saa 8:00 mchana','2:00 PM','Ibada ya ndoa takatifu','Holy matrimony service'),
('2026-12-06','Saa 7:00 mchana','1:00 PM','Semina ya wanandoa','Marriage seminar'),
('2026-12-13','Saa 4:00 asubuhi','10:00 AM','Ibada ya Ubarikio','Confirmation service'),
('2026-12-24','Saa 2:00 usiku','8:00 PM','Ibada ya mkesha wa Krismasi','Christmas Eve service'),
('2026-12-25','Saa 3:00 asubuhi','9:00 AM','Ibada ya Krismasi','Christmas Day service');

INSERT INTO sermons (sermon_date,title_sw,title_en,ref_sw,ref_en,preacher,youtube) VALUES
('2026-11-08','Kaeni ndani yangu','Abide in me','Yohana 15:1–8','John 15:1–8','Mch. Herman Kiporoza',''),
('2026-11-01','Kwa neema mmeokolewa','Saved by grace','Waefeso 2:8–10','Ephesians 2:8–10','Mch. Upendo Mushi',''),
('2026-10-25','Bwana ndiye mchungaji wangu','The Lord is my shepherd','Zaburi 23','Psalm 23','Mch. Herman Kiporoza',''),
('2026-10-18','Ninyi ni chumvi ya dunia','You are the salt of the earth','Mathayo 5:13–16','Matthew 5:13–16','Mwinj. Dilunga','');

INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (1,'Sikukuu ya Mavuno 2026','Harvest Festival 2026','Shukrani kwa Bwana kwa mavuno','Giving thanks to the Lord for the harvest','2026-11-29','matukio');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (1,'ikoni:wheat','','',0),(1,'ikoni:wheat','','',1),(1,'ikoni:music','','',2),(1,'ikoni:wheat','','',3),(1,'ikoni:cross','','',4),(1,'ikoni:wheat','','',5),(1,'ikoni:music','','',6),(1,'ikoni:wheat','','',7);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (2,'Ubatizo wa watoto','Infant baptism','Watoto wakipokea Sakramenti ya Ubatizo','Children receiving the sacrament of baptism','2026-11-22','matukio');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (2,'ikoni:drop','','',0),(2,'ikoni:drop','','',1),(2,'ikoni:cross','','',2),(2,'ikoni:drop','','',3),(2,'ikoni:drop','','',4);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (3,'Kwaya Kuu','Main Choir','Tukimsifu Bwana kwa nyimbo','Praising the Lord in song','2026-11-15','kwaya');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (3,'ikoni:music','','',0),(3,'ikoni:music','','',1),(3,'ikoni:music','','',2),(3,'ikoni:music','','',3),(3,'ikoni:music','','',4),(3,'ikoni:music','','',5);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (4,'Shule ya Jumapili','Sunday School','Watoto wakijifunza Neno la Mungu','Children learning God''s Word','2026-11-08','watoto');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (4,'ikoni:child','','',0),(4,'ikoni:child','','',1),(4,'ikoni:child','','',2),(4,'ikoni:child','','',3);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (5,'Ibada ya Jumapili','Sunday worship','Waumini wakimwabudu Mungu pamoja','The congregation worshipping together','2026-11-08','ibada');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (5,'ikoni:cross','','',0),(5,'ikoni:candle','','',1),(5,'ikoni:cross','','',2),(5,'ikoni:cross','','',3),(5,'ikoni:candle','','',4);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (6,'Kwaya ya Vijana','Youth Choir','Vijana wakimwimbia Bwana','Young people singing to the Lord','2026-11-01','kwaya');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (6,'ikoni:spark','','',0),(6,'ikoni:music','','',1),(6,'ikoni:spark','','',2),(6,'ikoni:music','','',3);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (7,'Ndoa takatifu','Holy matrimony','Baraka ya ndoa kanisani','The blessing of marriage in church','2026-10-24','matukio');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (7,'ikoni:rings','','',0),(7,'ikoni:rings','','',1),(7,'ikoni:cross','','',2),(7,'ikoni:rings','','',3);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (8,'Uongozi wa usharika','Parish leadership','Wachungaji wa Usharika wa Wazo','The pastors of Wazo parish','2026-10-01','uongozi');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (8,'images/mch-kiporoza.jpg','Mch. Herman Kiporoza · Mchungaji Kiongozi','Mch. Herman Kiporoza · Lead Pastor',0),(8,'images/mch-mushi.jpg','Mch. Upendo Mushi · Mchungaji Mwenza','Mch. Upendo Mushi · Co-Pastor',1);
INSERT INTO albums (id,title_sw,title_en,desc_sw,desc_en,album_date,category) VALUES (9,'Kanisa letu','Our church','Nyumba ya Bwana, Wazo','The house of the Lord, Wazo','2026-09-01','ibada');
INSERT INTO photos (album_id,path,caption_sw,caption_en,sort) VALUES (9,'images/kanisa-wazo.jpg','Jengo la kanisa, Wazo','The church building, Wazo',0);

INSERT INTO leaders (name,role_sw,role_en,photo,tier,sort) VALUES
('Mch. Herman Kiporoza','Mchungaji Kiongozi','Lead Pastor','images/mch-kiporoza.jpg','pastor',0),
('Mch. Upendo Mushi','Mchungaji Mwenza','Co-Pastor','images/mch-mushi.jpg','pastor',1),
('Mwinj. Dilunga','Mwinjilisti','Evangelist','','staff',2),
('Anold Kileo','Katibu wa Baraza','Council Secretary','','staff',3),
('[Jina]','Mhazini','Treasurer','','staff',4),
('[Jina]','Mwenyekiti wa Baraza la Wazee','Chair, Council of Elders','','staff',5);

INSERT INTO fellowships (icon,name_sw,name_en,desc_sw,desc_en,meet_sw,meet_en,sort) VALUES
('music','Kwaya Kuu','Main Choir','Huongoza uimbaji katika ibada kuu na sherehe za usharika.','Leads singing at main services and parish celebrations.','Jumanne, saa 12 jioni','Tuesdays, 6 PM',0),
('spark','Umoja wa Vijana','Youth Fellowship','Vijana hukutana kwa ibada, mijadala, michezo na huduma kwa jamii.','Young people meet for worship, discussion, sports and community service.','Jumapili, baada ya ibada','Sundays, after service',1),
('flower','Umoja wa Wanawake','Women''s Fellowship','Akina mama hujengana kiroho na kusaidia familia zenye uhitaji.','Women build one another up and support families in need.','Jumamosi ya pili ya mwezi','Second Saturday of the month',2),
('hands','Umoja wa Wanaume','Men''s Fellowship','Wanaume hushirikiana katika maombi, uongozi na miradi ya usharika.','Men share in prayer, leadership and parish projects.','Jumamosi ya mwisho ya mwezi','Last Saturday of the month',3),
('child','Shule ya Jumapili','Sunday School','Watoto hujifunza Biblia kwa nyimbo, hadithi na michezo.','Children learn the Bible through songs, stories and games.','Jumapili, saa 3 asubuhi','Sundays, 9 AM',4),
('dove','Kipaimara','Confirmation','Mafundisho ya imani kwa vijana wanaojiandaa kuthibitishwa.','Instruction in the faith for young people preparing to be confirmed.','Jumamosi, saa 3 asubuhi','Saturdays, 9 AM',5);

-- Hymn board sample (Mwimbieni Bwana numbers checked against hymnary.org)
INSERT INTO hymn_boards (sunday_date, book, hymns, note_sw, note_en) VALUES
('2026-11-15', 'MB', 'Kuingia: 161 – Bwana, twakuletea\nKabla ya Neno: 235 – Neno lako, Bwana wetu\nBaada ya mahubiri: 148 – Chini ya bawa lako\nMatoleo: 145 – Mwenyezi, mwenyezi, mwenyezi\nKufunga: 360 – Umngojee Bwana, moyo wangu', '', '');
