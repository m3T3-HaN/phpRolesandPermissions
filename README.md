# phpRolesandPermissions
php ile bir izin kümesinden detaylı arama fonksiyonu



Örnek bir izin kümemiz aşağıdaki gibi olsun
```php
$izinler = array(
      'auth.login',
      'auth.register',
      'dashboard.open',
      'dashboard.message.send',
      'dashboard.message.read',
      'app.project.*'
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
         
            foreach ($paracalaIzinKume as $perm){
            $tmp = []; //izin çok boyutlu olduğundan her birinin kontrol ederken geçiçi bir diziyi atama yapıyorum.
            $globalPatterns = false; //her yeni izin döngüsü için * izini false olarak ayarlıyorum

                foreach ($parcalaAranan as $key => $req){
                  if($perm[$key] == '*') $globalPattern = array_sum($tmp) == sizeof($tmp) ? true : false;
                  //eğer izin değerimiz * ise ve bundan öncekiler onaylanmışlar ise bundan sonra hepsine true ayarlıyorum.
                  
                  $tmp[$key] = $perm[$key] == $query ? 1 : ($perm[$key] == '*' ? 1 : ($globalPattern ? 1 : 0) );
                  //echo '$tmp['.$key.'] = '.$perm[$key].' == '.$query.' ? 1 : ('.$perm[$key].' == \'*\' ? 1 : ('.($globalPattern ? 'true' : 'false').' ? 1 : 0)) = '.$tmp[$key]."\n";
                  
                }
                //echo "\n\n\n";
                 if(sizeof($perm) == array_sum($tmp)) return true;
             
            }
            
            
```
 
 yukarıdaki sistem eğer izin eşleşme tam olarak sağlanırsa kendisini döngüden çıkarıp true döndürecek.
 eğer diyelim hiç eşleşme olmadı bu sefer false göndermemiz gerek onuda hemen aşağıya ekleyelim
 
 ```php
if(array_sum($tmp) == sizeof($tmp)) echo 'izin bulundu'; else echo 'izin bulunamadı';
```
