# Thư Viện API Facebook
## Overview
FBpost-lib ( gọi tạm thế đi :D) là thư viện PHP giúp bạn thao tác nhanh với API facebook. Phục vụ cho những công việc cơ bản bao gồm:
- [x] Trích xuất tên, định danh (id) danh sách người dùng đã React
- [x] Tính số lượng lượt Reactions trong một post
- [x] Tính số lượng người comment trong một post
- [x] Trích xuất thông tin người commnet trong một post
- [x] Thực hiện các thao tác: Tạo post, sửa post, xóa post
## CÁCH DÙNG
### Khai báo-khởi tạo
Tùy theo đối tượng bạn làm việc. Có thể chia phần này ra 3 tường hợp
+ Post FB Cá Nhân
Tiến hành config như sau: 
```php
$post = new PostInfo();
$post->_getToken($access_token);
$post->_getMyProfileId();
$post->_getPostId('Post ID');
```
Trong đó biến access_token là access token người dùng được cấp full quyền
+ Group
Tiến hành config như sau:
```php
$post = new PostInfo();
$post->_getToken($access_token);
$post->_getGroupId('ID Post');
$post->_getPostId('Post ID');
```
Trong đó biến access_token là access token người dùng được cấp full quyền. Đối tượng Group phải để ở trạng thái công khai
+ FanFage
```php
$post = new PostInfo();
$post->_getToken($access_token);
$post->_getFageId('FanFage Id');
$post->_getPostId('Post ID');
```
Trong đó biến access_token là access token fanfage được cấp full quyền.
### Các hàm:
Đã comment công dụng của hàm, parameter và kiểu trả về của hàm ở file post.php. Viết lên đây cho đủ đội hình thôi :v
## Thông tin tác giả
Tên: Trần Đức Ý
</br>
My email: ducy23061999.ghetdoi@gmail.com
</br>
Contact facebook: [Here](https://www.facebook.com/Tranducy1999)
