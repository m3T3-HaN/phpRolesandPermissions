<?php

    $perms = array(
      'auth.login',
      'auth.register',
      'dashboard.open',
      'dashboard.message.send',
      'dashboard.message.read'
    );

    function perm($check,$perms){

        $searchEx = explode('.',$check);
        
        $perms = array_map(function($perm){return explode('.',$perm);},$perms);

        $tmp = [];
        foreach ($perms as $perm){
            if(sizeof($perm) == 1 && $perm[0] == '*'){
                return true;
            }
            foreach ($searchEx as $key => $req){
                $tmp[$key] = $perm[$key] == '*' ? 1 : ($req == $perm[$key] ? 1 : 0);
            }
            if(sizeof($perm) == array_sum($tmp)) return true;
        }
        return sizeof($perm) == array_sum($tmp);
    }
    
    echo perm('auth.recoverpassword',$perms) ? 'izin var' : 'izin yok'; //Çıktısı: izin yok
    echo perm('auth.*',$perms) ? 'izin var' : 'izin yok'; //Çıktısı: izin var
