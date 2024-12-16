<?php
/**
 * WordPress için başlangıç ayar dosyası.
 *
 * Bu dosya kurulum sırasında wp-config.php dosyasının oluşturulabilmesi için
 * kullanılır. İsterseniz bu dosyayı kopyalayıp, ismini "wp-config.php" olarak değiştirip,
 * değerleri girerek de kullanabilirsiniz.
 *
 * Bu dosya şu ayarları içerir:
 * 
 * * Veritabanı ayarları
 * * Gizli anahtarlar
 * * Veritabanı tablo ön eki
 * * ABSPATH
 * 
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Veritabanı ayarları - Bu bilgileri servis sağlayıcınızdan alabilirsiniz ** //
/** WordPress için kullanılacak veritabanının adı */
define( 'DB_NAME', 'e-ticaret' );

/** Veritabanı kullanıcısı */
define( 'DB_USER', 'root' );

/** Veritabanı parolası */
define( 'DB_PASSWORD', '' );

/** Veritabanı sunucusu */
define( 'DB_HOST', 'localhost' );

/** Yaratılacak tablolar için veritabanı karakter seti. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Veritabanı karşılaştırma tipi. Herhangi bir şüpheniz varsa bu değeri değiştirmeyin. */
define( 'DB_COLLATE', '' );

/**#@+
 * Eşsiz doğrulama anahtarları ve tuzlar.
 *
 * Her anahtar farklı bir karakter kümesi olmalı!
 * {@link http://api.wordpress.org/secret-key/1.1/salt WordPress.org secret-key service} servisini kullanarak yaratabilirsiniz.
 * 
 * Çerezleri geçersiz kılmak için istediğiniz zaman bu değerleri değiştirebilirsiniz.
 * Bu tüm kullanıcıların tekrar giriş yapmasını gerektirecektir.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'HX&7n{gYSxL:$KMH-BOT4yT.2}):<QcDZy.!Ehj$RQ}YMMozy9eHjCFo_6b2WVM[' );
define( 'SECURE_AUTH_KEY',  'EUu}4B#rzIx4F8AaUUP!`JPU/<ZhjcEkeQ%)IC~8 #U#k?sx.{(%sKO]b){^Mwu}' );
define( 'LOGGED_IN_KEY',    '`4Bmn3NxcV}(2@x16dmH`cZ~&RrRP+tBZ`a9Ks6]ogU3w%>j,;v>h-Ci:gMD[  N' );
define( 'NONCE_KEY',        'k|^1-8iw8wcj(lIz{vx]nab{v$9vQM+2a1J (@)B>D8)nnhzZSt~6{o/l~.qK$9u' );
define( 'AUTH_SALT',        'S(][)yd4</9`FC{rfDP[T`p-_|{RjX=X8xPl?5;2oScID`G%{w_gxmikBb;2uw)o' );
define( 'SECURE_AUTH_SALT', '$o,S3FSG_)tMUK_-ODiH^Gj%r2to@]BZu3`v3V :/)i.210k U6KU*eM{Zyq%qvY' );
define( 'LOGGED_IN_SALT',   '[}UHA0u2|@-Jf&! ?5lApR_G*O=DrmI89=ck>x9 i8!`S`m7CZa)#){14-b+B^6{' );
define( 'NONCE_SALT',       '#uF$1F!FcCE$Q=9)l7!k.]LVJ_Mi2)Rr6lyhAtksbTf0Vs$HBu}$Ghl[%Dce}QsZ' );

/**#@-*/

/**
 * WordPress veritabanı tablo ön eki.
 *
 * Tüm kurulumlara ayrı bir önek vererek bir veritabanına birden fazla kurulum yapabilirsiniz.
 * Sadece rakamlar, harfler ve alt çizgi lütfen.
 */
$table_prefix = 'wp_';

/**
 * Geliştiriciler için: WordPress hata ayıklama modu.
 *
 * Bu değeri true olarak ayarlayıp geliştirme sırasında hataların ekrana
 * basılmasını sağlayabilirsiniz. Tema ve eklenti geliştiricilerinin geliştirme
 * aşamasında WP_DEBUG kullanmalarını önemle tavsiye ederiz.
 * 
 * Hata ayıklama için kullanabilecek diğer sabitler ile ilgili daha fazla bilgiyi
 * belgelerden edinebilirsiniz.
 * 
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Her türlü özel değeri bu satı ile "Hepsi bu kadar" yazan satır arasına ekleyebilirsiniz. */



/* Hepsi bu kadar. Mutlu bloglamalar! */

/** WordPress dizini için mutlak yol. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** WordPress değişkenlerini ve yollarını kurar. */
require_once ABSPATH . 'wp-settings.php';