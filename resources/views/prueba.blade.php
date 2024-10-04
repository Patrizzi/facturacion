{{ html()->modelForm($user,'PUT','/update-url')->open() }}
    {{html()->div()->opne}}
    {{html()->text('name')}}
    {{html()->email('email')}}

{{ html()->closeModelForm() }} 