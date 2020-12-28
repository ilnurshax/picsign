<?php


namespace App\Http\Controllers;


use App\Models\PictureSign;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\Imagick\Font;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImageSignController extends Controller
{

    public function sign()
    {
        $attributes = request()->validate([
            'country'  => 'required|string|min:3|max:50',
            'fullname' => 'required|string|min:3|max:50',
        ]);

        $picture = new PictureSign();
        $picture->country = $attributes['country'];
        $picture->fullname = $attributes['fullname'];
        $picture->save();

        $picture->hash = $picture->id . '-' . Str::random(32);
        $picture->save();


        $img = Image::make(public_path('certificate.jpg'));
        $img->text("Country: " . $picture->country, 120, 100, $this->mutateFont());
        $img->text("Fullname: " . $picture->fullname, 120, 200, $this->mutateFont());
        $img->text("Date: " . $picture->created_at->toDateString(), 120, 300, $this->mutateFont());
        $img->text("ID: {$picture->id}", 120, 400, $this->mutateFont());
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
            $font->size(64);
        };
    }
}
