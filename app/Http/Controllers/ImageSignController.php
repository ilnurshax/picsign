<?php


namespace App\Http\Controllers;


use App\Models\PictureSign;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\Imagick\Font;
use Johntaa\Arabic\I18N_Arabic;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageSignController extends Controller
{

    /**
     * @var I18N_Arabic
     */
    private $arabic;

    public function sign()
    {
//        $attributes = request()->validate([
//            'country'  => 'required|string|min:3|max:50',
//            'fullname' => 'required|string|min:3|max:50',
//        ]);

        $attributes = [
            'fullname' => 'الإسم',
            'country'  => 'البلد\المدينة',
        ];

        $picture = new PictureSign();
        $picture->country = $attributes['country'];
        $picture->fullname = $attributes['fullname'];
        $picture->save();

        $picture->hash = $picture->id . '-' . Str::random(32);
        $picture->save();

        $img = Image::make(public_path('certificate.jpg'));
        $img->text($this->toArabic($picture->fullname), 830, 557, $this->mutateFont());
        $img->text($this->toArabic($picture->country), 740, 625, $this->mutateFont());

        $serial = 100 + $picture->id;
        $img->text($serial . '/' . $picture->created_at->toDateString(), 600, 675, $this->mutateFont());

        $img->save($path = public_path($picture->getPath()));

        return redirect()->route('show', $picture->hash);
    }

    public function show(string $hash)
    {
        /** @var PictureSign|null $ps */
        $ps = PictureSign::query()->firstWhere('hash', $hash);
        if ($ps === null) {
            throw new NotFoundHttpException();
        }

        return view('show', [
            'picture_path' => $ps->getPath(),
        ]);
    }

    /**
     * @return \Closure
     */
    protected function mutateFont(): \Closure
    {
        return function (Font $font) {
            $font->file(resource_path('fonts/Amiri-Regular.ttf'));
            $font->size(32);
            $font->align('right');
        };
    }

    protected function toArabic(string $fullname)
    {
        $arabic = new I18N_Arabic('Glyphs');

        return $arabic->utf8Glyphs($fullname);
    }
}
