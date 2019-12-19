\encoding utf8
--職業マスタ挿入部
insert into "Jobs" values (1,'システムエンジニア');
insert into "Jobs" values (2,'プログラマー');
insert into "Jobs" values (3,'その他');
insert into "Jobs" values (4,'学生');
insert into "Jobs" values (5,'無職');
--酒マスタ挿入部
insert into "Alchol" values (1,'ビール');
insert into "Alchol" values (2,'カクテル');
insert into "Alchol" values (3,'チューハイ');
insert into "Alchol" values (4,'日本酒');
insert into "Alchol" values (5,'ワイン');
insert into "Alchol" values (6,'ウイスキー');
insert into "Alchol" values (7,'ウォッカ');
insert into "Alchol" values (8,'リキュール');
insert into "Alchol" values (9,'焼酎');

--分類マスタ挿入部
insert into "Categories" values (DEFAULT,'CLI','コマンドプロンプトから起動するアプリケーションのこと');
insert into "Categories" values (DEFAULT,'GUI','グラフィックを用いたアプリケーションのこと');

--ユーザー分類マスタ挿入部
insert into "UserCategories" values (DEFAULT,'初心者向け','誰でも分かるレベルのプログラムのことで分かりやすく説明しているのも対象とする');
insert into "UserCategories" values (DEFAULT,'上級者向け','一部の者しか分からないため、知識が必要となるレベルのことである');

--言語マスタ挿入部
insert into "Language" values (0,'その他');
insert into "Language" values (1,'C');
insert into "Language" values (2,'C++');
insert into "Language" values (3,'Java');
insert into "Language" values (4,'C#');
insert into "Language" values (5,'PHP');
insert into "Language" values (6,'Python');
insert into "Language" values (7,'Ruby');
insert into "Language" values (8,'JavaScript');
insert into "Language" values (9,'Dart');
insert into "Language" values (10,'Golang');
insert into "Language" values (11,'Kotlin');
insert into "Language" values (12,'HTML');
insert into "Language" values (13,'CSS');
insert into "Language" values (14,'SQL');

--言語拡張子マスタ挿入部
insert into "Extension" values (1,'c');
insert into "Extension" values (2,'cpp');
insert into "Extension" values (2,'cc');
insert into "Extension" values (2,'cxx');
insert into "Extension" values (2,'c++');
insert into "Extension" values (2,'cc3');
insert into "Extension" values (3,'java');
insert into "Extension" values (4,'cs');
insert into "Extension" values (4,'csx');
insert into "Extension" values (5,'php');
insert into "Extension" values (5,'php3');
insert into "Extension" values (5,'php4');
insert into "Extension" values (5,'php5');
insert into "Extension" values (5,'php7');
insert into "Extension" values (5,'phps');
insert into "Extension" values (5,'phpt');
insert into "Extension" values (5,'phtml');
insert into "Extension" values (6,'py');
insert into "Extension" values (7,'rb');
insert into "Extension" values (8,'js');
insert into "Extension" values (8,'htc');
insert into "Extension" values (9,'dart');
insert into "Extension" values (10,'go');
insert into "Extension" values (11,'ko');
insert into "Extension" values (12,'html');
insert into "Extension" values (13,'css');
insert into "Extension" values (14,'sql');
insert into "Extension" values (0,null);
--テストアカウント
insert into "Account" values(DEFAULT,'kousukeex','kousuke','test','a','渥美','光将',to_date('1997-09-01','YYYY-MM-DD'),CURRENT_DATE,1);