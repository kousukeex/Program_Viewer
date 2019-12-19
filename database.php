<?php
class DataBasePDO{

    private $pdo;

    public function __construct(){
        $this->pdo = new PDO('pgsql:dbname=ProgramViewer;host=localhost;port=5432','Program_Guest',"");
    }

    public function AccessProgram($programid){
        
        $stmt = $this->pdo->query(
        'select P.programname,P.description,P.createdate,P.updatedate,P.categoryid,C.categoryname,A.username '.
        'from "Program" P,"Categories" C,"Account" A '.
        'where P.categoryid = C.categoryid '.
        'and P.authorid = A.userid '.
        'and P.programid = '.$programid);
        return $stmt->fetch();
    }

    public function AccessProgramFile($programid){
        $stmt = $this->pdo->query(
        'select S.fileid,S.filename,L.languagename,S.updatedate '.
        'from "Source" S,"Language" L,"Program" P,"ProgramRelationSource" PS '.
        'where P.programid = PS.programid '.
        'and S.fileid = PS.fileid '.
        'and S.language = L.languageid '.
        'and P.programid = '.$programid.' '.
        'order by fileid asc'
        );
        return $stmt->fetchAll();
    }

    public function AccessSourceFile($fileid){
        $stmt = $this->pdo->query(
        'select S.filename,S.filepath,S.authorid,A.username from "Source" S,"Account" A '.
        'where S.authorid = A.userid '.
        'and S.fileid = '.$fileid
        );
        return $stmt->fetch();
    }

    public function AccountRegister($Account_Array){        
        $birthdayString=$Account_Array["birthYear"]."-".
        str_pad($Account_Array["birthMonth"],2,0,STR_PAD_LEFT)."-".
        str_pad($Account_Array["birthDay"],2,0,STR_PAD_LEFT);

        try{
        $registersql = $this->pdo->prepare("
        INSERT INTO \"Account\" values (DEFAULT,:loginid,:password,:username,:email,:lastname,:firstname,to_date(:date,'YYYY-MM-DD'),CURRENT_DATE,:jobid)");
        $registersql->bindValue(":loginid",$Account_Array["loginID"]);
        $registersql->bindValue(":password",$Account_Array["password"]);
        $registersql->bindValue(":username",$Account_Array["username"]);
        $registersql->bindValue(":email",$Account_Array["email"]);
        $registersql->bindValue(":lastname",$Account_Array["lastname"]);
        $registersql->bindValue(":firstname",$Account_Array["firstname"]);
        $registersql->bindValue(":jobid",$Account_Array["jobid"]);
        $registersql->bindValue(":date",$birthdayString);
        
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }catch(Exception $e){
            var_dump($e->getMessage());
        }
        return $registersql->execute();
    }

    public function AccountMatching($loginID){
        if($this->pdo->query('select LoginID from Account where LoginID='.$loginID)==false){
            return false;
        }
        return true;
    }

    public function AccountAuthrize($LoginID,$password){
        $login = $this->pdo->prepare('
        select LoginID,username,userid from "Account"
        where LoginID = :LoginID
        and password = :password');
        $login->bindValue(":LoginID",$LoginID);
        $login->bindValue(":password",$password);
        $login->execute();
        $result = $login->fetch();
        if(!$result)
            return false;
        return $result;
    }

    public function getUserid($loginID){
        $stmt = $this->pdo->prepare(
        'select userid from "Account" '. 
        'where loginID = \''.$loginID.'\''
        );
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAuthoridbyFile($fileid){
        $stmt = $this->pdo->prepare(
        'select authorid '.
        'from "Source" '.
        'where fileid = '.$fileid
        );
        $stmt->execute();
        return $stmt->fetch();
    }

    public function AssociateSource($programid,$fileid){
        $stmt = $this->pdo->prepare('insert into "ProgramRelationSource" values(:pid,:fid)');
        $stmt->bindValue(":pid",$programid);
        $stmt->bindValue(":fid",$fileid);
        $stmt->execute();
    }

    public function findAccountID($loginID){
        $stmt = $this->pdo->prepare('select userid from "Account" where loginid = :loginID');
        $stmt->bindValue(":loginID",$loginID);
        $stmt->execute();
        $data = $stmt->fetch();
        return $data[0];
    }

    public function listJobs(){
        return $this->pdo->query('select * from "Jobs"');
    }

    public function listCategories(){
        return $this->pdo->query('select * from "Categories"');
    }

    public function listPrograms($date,$keyword,$category){
        $sql = 'select P.*,A.username,C.categoryname from "Program" P '.
               'inner join "Account" A on P.authorid = A.userid '.
               'inner join "Categories" C on P.categoryid = C.Categoryid ';
        if($keyword != "")
            $sql .= "where programname like '%".$keyword."%'";
        if($category != -1 && $keyword != "")
            $sql .= "and P.categoryid = ".$category;
        else if($category != -1)
            $sql .= "where P.categoryid = ".$category;
        
        if($date == "newer")
            $sql .= "order by createdate desc";
        else if($date == "older")
            $sql .= "order by createdate asc";
        else if($date == "unewer")
            $sql .= "order by updatedate desc";
        else if($date == "uolder")
            $sql .= "order by updatedate asc";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt;
    }

    public function listProgramsByAccount($userid){
        $programs = $this->pdo->query(
        'select P.*,A.username,C.categoryname from "Program" P '.
        'inner join "Account" A on P.authorid = A.userid '.
        'inner join "Categories" C on P.categoryid = C.Categoryid '.
        'where P.authorid = '.$userid.' '.
        'order by updatedate desc'
        );
        return $programs->fetchAll();
    }

    public function getProgramID(){
        $stmt = $this->pdo->prepare('select last_value,is_called from "Program_programid_seq"');
        $stmt->execute();
        $programid = $stmt->fetch();
        return $programid[0];
    }

    public function getProfile($userid){
        $stmt = $this->pdo->prepare('select A.username,J.jobname from "Account" A inner join "Jobs" J on A.jobid = J.jobid where userid = :userid');
        $stmt->bindValue(":userid",$userid);
        $stmt->execute();
        $profile = $stmt->fetch();
        return $profile;
    }

    public function getFileID(){
        $stmt = $this->pdo->prepare('select last_value,is_called from "Source_fileid_seq"');
        $stmt->execute();
        $fileid = $stmt->fetch();
        return $fileid[0];
    }

    public function getLanguageID($filename){
        $fileinfo = pathinfo($filename);
        $extension = $fileinfo["extension"];
        $stmt = $this->pdo->prepare('select * from "Extension" where suffix = :extension');
        $stmt->bindValue(':extension',$extension);
        $stmt->execute();
        $languageID = $stmt->fetch();
        return $languageID[0];
    }

    public function uploadProgram($programname,$description,$authorid,$categoryid){
        $programstmt = $this->pdo->prepare('insert into "Program" values(DEFAULT,:programname,:description,:authorid,DEFAULT,DEFAULT,:categoryid)');
        $programstmt -> bindValue(":programname",$programname);
        $programstmt -> bindValue(":description",$description);
        $programstmt -> bindValue(":authorid",$authorid);
        $programstmt -> bindValue(":categoryid",$categoryid);
        if($programstmt->execute())
            return $this->getProgramID();
        return null;
    }

    public function uploadProgramFiles($filename,$filepath,$authorid){
        $languageID = $this->getLanguageID($filename);
        $stmt = $this->pdo->prepare('insert into "Source" values(DEFAULT,:filename,:filepath,:authorid,:language,DEFAULT)');
        $stmt->bindValue(":filename",$filename);
        $stmt->bindValue(":filepath",$filepath);
        $stmt->bindValue(":authorid",$authorid);
        $stmt->bindValue(":language",$languageID);
        if($stmt->execute())
            return $this->getFileID();
        return null;
    }

    public function updateFile($fileid,$filename){
        $stmt = $this->pdo->prepare(
        'update "Source" '.
        'set updatedate = CURRENT_TIMESTAMP,filename = :filename '.
        'where fileid = '.$fileid
        );
        $stmt->bindValue(":filename",$filename);
        $stmt->execute();
        $stmt = $this->pdo->prepare(
        'update "Program" '.
        'set updatedate = CURRENT_TIMESTAMP '.
        'where programid = ('.
        '       select programid from "ProgramRelationSource" '.
        '       where fileid = '.$fileid.
        '       )'
        );
    }

}
    
?>