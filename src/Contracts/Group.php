<?php

namespace TekVN\Setting\Contracts;

interface Group
{
    /**
     * Lấy tên nhóm cài đặt
     */
    public function getGroupName(): string;

    /**
     * Lấy 1 instance của StoreManager
     */
    public function getStore(): Store;

    /**
     * Lấy tất cả cài đặt có trong nhóm
     */
    public function all(): array;

    /**
     * Lấy chi tiết 1 cài đặt cụ thể. Nếu không tìm thấy thì $default sẽ được trả về
     * Lưu ý: nếu $default là 1 Closure thì gía trị của nó sẽ được trả về
     */
    public function get(string|array $key, mixed $default = null): mixed;

    /**
     * Đặt giá trị mới cho $key. Nếu $value là Closure thì giá trị của nó sẽ được lưu
     */
    public function set(string|array $key, mixed $value = null): void;

    /**
     * Trả về driver store đang sử dụng
     * Nếu null thì sẽ sử dụng store mặc định
     */
    public function getStoreDriver(): ?string;

    /**
     * Hàm thực hiện nhiệm vụ làm mới cài đặt
     */
    public function reload(): void;
}
