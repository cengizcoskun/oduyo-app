# Oduyo App

##  Kurulum

Projeyi bilgisayarımıza klonluyoruz.

`git clone git@github.com:cengizcoskun/oduyo-app.git`

Proje dizininde şu komutu çalıştırıyoruz: `sail up -d`

Son olarak frontend dosyalarını derliyoruz: `sail npm run build`

Case Study: Laravel Tabanlı Ödeme Sistemi ve Garanti Sanal POS Entegrasyonu

### Amaç

Laravel 11, MySQL ve Vue.js kullanarak güvenli ve sağlam bir ödeme platformu geliştirmek, Garanti sanal POS ile dokümanına uygun şekilde 3D ve 2D işlemleri gerçekleştirebilmek.



### Proje Özeti

Ödeme sistemi, yapılandırma için bir Laravel yönetim panelini ve ödeme arayüzü için Vue.js tabanlı bir frontend içerecektir. Öne çıkan özellikler şunlardır:

* Kart bilgileri girilebilecek bir ödeme sayfası.
* Garanti sanal POS ile uyumlu olarak 3D ve 2D işlem desteği.
* Yönetim panelinden dinamik olarak POS bilgilerini yönetebilme.
* Laravel’in en iyi uygulamalarıyla kullanıcı giriş/çıkış işlemlerinin sağlanması.



### Teknik Gereksinimler

1. Backend (Laravel 11)
    - Ödeme Entegrasyonu: Garanti POS ile 3D ve 2D işlem gerçekleştirme. Entegrasyon detayları için Garanti BBVA API Kataloğu kullanılabilir.
    - Yönetim Paneli: Yöneticilerin POS ayarlarını dinamik olarak yapılandırabilmesi.
    - Kimlik Doğrulama: Laravel'in kimlik doğrulama standartlarına uygun kullanıcı giriş/çıkış işlemleri.
    - Loglama: Kullanıcı aktiviteleri ve giriş oturumlarının izlenmesi.
2. Frontend (Vue.js)
    - Ödeme Sayfası: Kullanıcı dostu bir arayüzle kart bilgilerinin girilmesi.
    - Dinamik POS Yapılandırması: Yönetim panelindeki POS ayarlarını ödeme sayfasında yansıtma.
3. Veritabanı (MySQL)
    - Kullanıcı Yönetimi: Kullanıcı verilerini güvenli şekilde takip etme.
    - POS Yapılandırması: POS ayarları ve işlem loglarını izlemek için veritabanında saklama.
4. Güvenlik
    - Veri Şifreleme: Kart bilgileri gibi hassas bilgilerin korunması.
    - Rol Tabanlı Erişim Kontrolü (RBAC): Yönetim özelliklerine erişimi sınırlama.




