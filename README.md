# phpRolesandPermissions
php ile bir izin kümesinden detaylı arama fonksiyonu



Örnek bir izin kümemiz aşağıdaki gibi olsun
```php
$izinler = array(
      'auth.login',
      'auth.register',
      'dashboard.open',
      'dashboard.message.send',
      'dashboard.message.read'
  );
```
 
  Şimdi bu izin kümesinde giriş yapabilmek için kullanıcıda auth.login izinini arayalım.
  
```php
  $aranan = 'auth.login';
```
  
  Öncelikle aradığımız izini ve diğer izinleri belirteçlerine göre parçalamamız gerekli
  ben belirteç olarak . kullandım siz farklı da kullanabilirsiniz. Ama izin kümenizi ona göre tasarlamalısınız.
 
```php
  $parcalaAranan = explode('.',$aranan);
  $paracalaIzinKume = array_map(function($izin){ return explode('.',$izin); },$izinler);
```
  
  Şimdi gelelim arama fonksiyonumuza burda sorun izin kümesinde izin kaç boyutlu (boyut derken izin lerimiz ayırdığımız kısım belirteçlerle misal auth.login 2 boyut olarak isimlendiriyorum.) bunu kontrol edebilmek için 2 tane foreach işimizi görüyor. Aslında array_filter işimizi görürdü fakat array_filter php Array sınıfının bir özelliği olduğundan onu kullandığımda değişkenime erişemiyorum.
  
```php
            $tmp = []; //izin çok boyutlu olduğundan her birinin kontrol ederken geçiçi bir diziyi atama yapıyorum.
            foreach ($paracalaIzinKume as $perm){
                if(sizeof($searchEx) == 1 && $searchEx[0] == '*'){
                    echo 'aramaya gerek yok: adam global perm'."\n";
                    echo 'izin bulundu';
                    return true;
                }
                foreach ($parcalaAranan as $key => $req){
                    $tmp[$key] = $req == '*' ? 1 : ($req == $perm[$key] ? 1 : 0);
                    echo 'Aranan: '.$req." == ".$perm[$key]." = ".($req == $perm[$key] ? 'var' : 'yok')."\n";
                }
                echo "Dizi Büyüklüğü: ".sizeof($perm)." -> Doğrulama: ".array_sum($tmp)."\n";
                if(sizeof($perm) == array_sum($tmp)){
                  echo 'izin bulundu';return true;
                }
             
            }
```
 
 yukarıdaki sistem eğer izin eşleşme tam olarak sağlanırsa kendisini döngüden çıkarıp true döndürecek.
 eğer diyelim hiç eşleşme olmadı bu sefer false göndermemiz gerek onuda hemen aşağıya ekleyelim
 
 ```php
if(sizeof($perm) == array_sum($tmp)) echo 'izin bulundu'; else echo 'izin bulunamadı';
```
