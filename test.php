<?php

    $perms = array(
      'auth.login',
      'auth.register',
      'dashboard.open',
      'dashboard.message.send',
      'dashboard.message.read',
      'app.project.*'
    );

    function perm($check,$perms){

        $queryPermSlot = explode('.',$check);
        $lib = array_map(function($perm){return explode('.',$perm);},$perms);

        foreach ($lib as $perm){
            $tmp = [];$globalPattern = false;

            foreach ($queryPermSlot as $key => $query) {
                if($perm[$key] == '*') $globalPattern = array_sum($tmp) == sizeof($tmp) ? true : false;

                //echo '$tmp['.$key.'] = '.$perm[$key].' == '.$query.' ? 1 : ('.$perm[$key].' == \'*\' ? 1 : ('.($globalPattern ? 'true' : 'false').' ? 1 : 0)) = ';
                $tmp[$key] = $perm[$key] == $query ? 1
                    : ($perm[$key] == '*' ? 1
                        : ($globalPattern ? 1 : 0) );
                //echo $tmp[$key]."\n";

            }
            //echo "\n\n\n";

            if(sizeof($perm) == array_sum($tmp)) return true;
        }
        return array_sum($tmp) == sizeof($tmp);
    }
    
    echo perm('auth.recoverpassword',$perms) ? 'izin var' : 'izin yok'; //Çıktısı: izin yok
    echo perm('auth.login',$perms) ? 'izin var' : 'izin yok'; //Çıktısı: izin var
