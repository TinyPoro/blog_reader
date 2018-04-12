## Blog Reader
- Author: *Ngô Phương Tuấn*

##### Usage
- Tạo 1 đối tượng `Reader` từ `url` đầu vào, tùy vào đường dẫn đầu vào hệ thống sẽ trả về cho bạn đối tượng `Reader` tương ứng. Nếu hệ thống không hỗ trợ, hệ thống sẽ ném ra `BlogNotFoundException`.
```
$blog = BlogReader::fromUrl(url) 
```

- Lấy thông tin về blog/wp hiện tại.
```
$blog->getInfo();
```

- Lấy thông tin về các bài đăng trang hiện tại. Hàm nhận 3 tham số đầu vào, trong đó `post_array` là các trường thông tin bạn muốn lấy, `page` là trang bạn muốn lấy, và `per_page` là số bài viết trên trang bạn muốn lấy.
```
$blog->posts($post_array, $page, $per_page)
```

- Lấy thông tin về các bài viết trang tiếp theo.
```
$blog->next();
```

- Lấy số về trang hiện tại.
```
$blog->current_page();
```

- Cài đặt `keyword` và lấy thông tin về các bài đăng có chưa từ khóa theo cài đặt trang hiện tại.
```
$blog->setKeyword($keyword);
```

- Xóa `keyword` hiện tại.
```
$blog->resetKeyword();
```

- Lấy các `label` trên trang hiện tại, giới hạn bởi tham số đầu vào `max`.
```
$blog->labels($max);
```