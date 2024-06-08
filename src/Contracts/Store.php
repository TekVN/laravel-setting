<?php

namespace DNT\Setting\Contracts;

interface Store
{
    /**
     * Truy xuất một mục từ cài đặt bằng $key.
     */
    public function get(string $key, mixed $default = null, string $group = 'default'): mixed;

    /**
     * Đặt giá trị mới cho $key
     */
    public function set(string|array $key, mixed $value = null, string $group = 'default'): mixed;

    /**
     * Kiểm tra $key đã có chưa
     */
    public function has(string $key, string $group = 'default'): bool;

    /**
     * Lấy tất cả cài đặt từ nhóm
     */
    public function allFromGroup(string $group): array;

    /**
     * Lấy tất cả cài đặt
     */
    public function all(): array;

    /**
     * Tải lại toàn bộ cài đặt mới
     */
    public function reload(): void;
}
