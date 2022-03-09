<?php


namespace App\Helpers;


class Helper
{
    public static function category_list($categories, $parent_id = 0,$char = ''){
        $html = '';
        foreach ($categories as $key=>$category){
            if ($category->parent_id == $parent_id){
                $html .= '
                    <tr>
                        <td>' . $category->id . '</td>
                        <td>' . $char . $category->name . '</td>
                        <td>' . $category->description . '</td>
                        <td>' . $category->tax . '</td>
                        <td>' . $category->unit . '</td>
                        <td><a href="'.$category->photo.'" target="_blank">
                                <img class="img-thumbnail" width="60px" src="'.$category->photo.'" alt="'.$category->name.'"/>
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-primary btn-sm" href="/admin/categories/edit/'.$category->id.'">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a class="btn btn-danger btn-sm" href="#"
                                onclick="removeRow(' . $category->id . ',\'/admin/categories/delete\')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                ';
                unset($categories[$key]);
                $html .= self::category_list($categories,$category->id,$char .'|--');
            }
        }
        return $html;
    }

    public static function active($active = 0){
        return $active == 0 ? '<span class="btn btn-danger btn-xs">NO<span>'
            :'<span class="btn btn-success btn-xs">YES<span>';
    }

    public static function price($price){
        if ($price!=null)return '$'.number_format($price);
        return '<a style="color: blue" href="/contact">Contact us</a>';
    }

    public static function categories($categories ,$parent_id =0){
        $html = '';
        foreach ($categories as $key => $category){
            if ($category -> parent_id == $parent_id){
                $html .= '
                    <li>
                        <a href="/shop/'.$category->id.'">
                            ' . $category->name . '
                        </a>
                    </li>
                    ';
            }
        }
        return $html;
    }

}
