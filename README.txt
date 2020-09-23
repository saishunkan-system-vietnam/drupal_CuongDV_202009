# Drupal_docker
Drupal 8 + MariaDB 10.4 + PHP7.3

# run
docker-compose up --build -d

# remove
docker-compose down

# Yêu cầu cần thực hiện:
- Update source Drupal 8 ở docker lên bản 8 mới nhất.
- Tạo trang detail seminar có các thông tin sau: 
Ngày diễn ra seminar, ngày tiếp nhận apply, tên seminar, nội dung seminar, thông tin diễn giả (tên - ảnh) (có thể nhập nhiều diễn giả), button apply.

- Tạo trang views danh sách diễn giả:
Ngày diễn ra seminar, tên seminar, nội dung rút gọn của seminar, thông tin diễn giả, button apply (trường hơpk ngoài ngày tiếp nhận thì sẽ hiển thị màu xám).

- Tạo form đăng ký apply:
Họ tên người apply, tuổi, giới tính, công ty làm việc.

# Các khái niệm cần tìm hiểu:
- Themes, module, hook, filter trong drupal.
- Entity, node, content, block, view, paragraph, field.
- Form input.
- Custom theme, module, đưa field ra page content detail hoặc view content.

