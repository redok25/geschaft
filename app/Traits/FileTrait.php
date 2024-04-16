<?php

namespace App\Traits;

trait FileTrait
{
    /**
     * Upload a file to the specified directory.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $directory
     * @param  string  $file_name
     * @return string|false
     */
    public function upload_file($file, $directory = 'uploads', $file_name)
    {
        if ($file->isValid()) {
            $file_name = $file_name . '.' . $file->getClientOriginalExtension();
            $path = $file->move(public_path($directory), $file_name);
            return url("{$directory}/{$file_name}");
        }
        return false;
    }

    /**
     * Delete a file from the specified directory.
     *
     * @param  string  $path
     * @return bool
     */
    public function delete_file($path)
    {
        if (file_exists(public_path($path))) {
            return unlink(public_path($path));
        }
        return false;
    }

    /**
     * Upload and replace existing file, then delete old file.
     *
     * @param  \Illuminate\Http\UploadedFile  $new_file
     * @param  string  $old_file_path
     * @param  string  $directory
     * @param  string  $file_name
     * @return string|false
     */
    public function replace_file($new_file, $old_file_path, $directory = 'uploads', $file_name)
    {
        $new_file_path = $this->upload_file($new_file, $directory, $file_name);

        if ($new_file_path) {
            if ($this->delete_file($old_file_path)) {
                return $new_file_path;
            }
        }

        return false;
    }
}
