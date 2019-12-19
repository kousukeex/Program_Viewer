/*
 *テーブル定義スクリプト
 *14個のデータベースを構築する
 */

/*
 * マスタテーブルを定義
 */
\encoding utf8
create table "Jobs"(
    jobID int primary key,
    jobName varchar(24)
);
create table "Alchol"(
    AlcholID int primary key,
    Name varchar(8)
);
create table "Categories"(
    CategoryID Serial primary key,
    CategoryName varchar(64),
    Description varchar(512),
    UNIQUE(CategoryName)
);
create table "UserCategories"(
    CategoryID Serial primary key,
    CategoryName varchar(64),
    Description varchar(512)
);
create table "Language"(
    LanguageID int primary key,
    LanguageName varchar(24)
);

create table "Extension"(
    LanguageID int references "Language"(LanguageID),
    Suffix varchar(32)
);

/*
* テーブル定義
*/

create table "Account"(
    UserID Serial primary key,
    LoginID varchar(32),
    PassWord varchar(15),
    UserName varchar(32),
    Email text,
    LastName varchar(6),
    FirstName varchar(12),
    Birthday date,
    RegisterDay date,
    jobID int references "Jobs"(jobID),
    unique(LoginID)
);

create table "AlcholLike"(
    UserID int references "Account"(UserID),
    AlcholID int references "Alchol"(AlcholID),
    primary key(UserID,AlcholID)
);

create table "Program"(
    ProgramID bigSerial primary key,
    ProgramName varchar(255),
    Description text,
    AuthorID bigint references "Account"(UserID),
    CreateDate timestamp DEFAULT localtimestamp,
    UpdateDate timestamp DEFAULT localtimestamp,
    CategoryId int
);

create table "UserCategorisedPrograms"(
    ProgramID bigint references "Program"(ProgramID),
    CategoryID int references "UserCategories"(CategoryID), 
    primary key(ProgramID,CategoryID)
);

create table "ProgramComment"(
    ProgramID bigint references "Program"(ProgramID),
    CommentNumber int,
    CommentContent varchar(512),
    primary key(ProgramID,CommentNumber)
);

create table "ProgramCommentRelation"(
    ProgramID bigint,
    ReplyCommentNumber int,
    SourceCommentNumber int,
    foreign key(ProgramID,ReplyCommentNumber) references "ProgramComment"(ProgramID,CommentNumber)
);

create table "Source"(
    FileID Serial primary key,
    FileName varchar(255),
    Filepath text,
    AuthorID int references "Account"(UserID),
    Language int references "Language"(LanguageID),
    Updatedate timestamp default localtimestamp
);

create table "ProgramRelationSource"(
    ProgramID int references "Program"(ProgramID),
    FileID int references "Source"(FileID)
);

SELECT setval('"Account_userid_seq"',1,false);
SELECT setval('"Categories_categoryid_seq"',1,false);
SELECT setval('"Program_programid_seq"',1,false);
SELECT setval('"Source_fileid_seq"',1,false);
SELECT setval('"UserCategories_categoryid_seq"',1,false);