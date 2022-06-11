<?php

namespace App\Form;

use App\Entity\Pin;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class PinType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
            'label'=> 'Image (JPG ou PNG file)',
            'required' => false,
            'delete_label' => 'Delete ?',
            'allow_delete' => true,
            'download_uri' => false,
            'imagine_pattern' =>'squared_thumbnail_small',
            ])

            ->add('title',TextType::class)
            ->add('description',TextareaType::class)

          ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pin::class,
        ]);
    }
}
